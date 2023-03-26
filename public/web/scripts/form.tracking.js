$(document).ready(function () {
    var eventIds = {
        fieldCompleted: "2ca692cb-bdb2-4c9d-a3b5-917b3656c46a",
        fieldError: "ea27aca5-432f-424a-b000-26ba5f8ae60a"
    };

    function endsWith(str, suffix) {
        return str.toLowerCase().indexOf(suffix.toLowerCase(), str.length - suffix.length) !== -1;
    }

    function getOwner(form, elementId) {
        var targetId = elementId.slice(0, -(elementId.length - elementId.lastIndexOf(".") - 1)) + "Value";
        return form.find("input[name=\"" + targetId + "\"]")[0];
    }

    function getSessionId(form) {
        var formId = form[0].id;
        var targetId = formId.slice(0, -(formId.length - formId.lastIndexOf("_") - 1)) + "FormSessionId";
        var element = form.find("input[type='hidden'][id=\"" + targetId + "\"]");
        return element.val();
    }

    function getElementName(element) {
        var fieldName = element.name;
        if (!endsWith(fieldName, "value")) {
            return getFieldGuid(fieldName) + "Value";
        }

        return fieldName;
    }

    function getElementValue(element) {
        var value;
        if (element.type === "checkbox" || element.type === "radio") {
            var form = $(element).closest("form");
            var checkboxList = form.find("input[name='" + element.name + "']");
            if (checkboxList.length > 1) {
                value = [];
                checkboxList = checkboxList.not(":not(:checked)");
                $.each(checkboxList, function () {
                    value.push($(this).val());
                });
            } else {
                value = element.checked ? "1" : "0";
            }
        } else {
            value = $(element).val();
        }

        if (value && Object.prototype.toString.call(value) === "[object Array]") {
            value = value.join(",");
        }

        return value;
    }

    function getFieldGuid(fieldName) {
        var searchPattern = "fields[";
        var index = fieldName.toLowerCase().indexOf(searchPattern);
        return fieldName.substring(0, index + searchPattern.length + 38);
    }

    function getFieldName(element) {
        return $(element).attr("data-sc-field-name");
    }

    $.fxbFormTracker = function (el, options) {
        this.el = el;
        this.$el = $(el);
        this.options = $.extend({}, $.fxbFormTracker.defaultOptions, options);
        this.init();
    },

        $.fxbFormTracker.parse = function (formId) {
            var $form = $(formId);
            $form.track_fxbForms();

            var isSessionExpired = parseInt($("[name$='.IsNewSession']").val());
            if (isSessionExpired) {
                alert($.fxbFormTracker.texts.expiredWebSession);
            }
        },

        $.extend($.fxbFormTracker,
            {
                defaultOptions: {
                    formId: null,
                    sessionId: null,
                    fieldId: null,
                    fieldValue: null,
                    duration: null
                },

                prototype: {
                    init: function () {
                        this.options.duration = 0;
                        this.options.formId = this.$el.attr("data-sc-fxb");
                    },

                    startTracking: function () {
                        this.options.sessionId = getSessionId(this.$el);

                        var self = this;
                        var inputs = this.$el.find("input:not([type='submit']), select, textarea");
                        var trackedInputs = inputs.filter("[data-sc-tracking='True'], [data-sc-tracking='true']");
                        var trackedNonDateInputs = trackedInputs.not("[type='date']");

                        if (trackedInputs.length) {
                            inputs.not(trackedInputs).on("focus",
                                function () {
                                    self.onFocusField(this);
                                });

                            trackedInputs.on("focus",
                                function () {
                                    self.onFocusField(this, true);
                                }).on("blur",
                                    function () {
                                        self.onBlurField(this);
                                    });

                            trackedNonDateInputs.on("change",
                                function () {
                                    self.onBlurField(this);
                                });
                        }
                    },

                    onFocusField: function (element, hasTracking) {
                        if (!hasTracking) {
                            this.options.fieldId = "";
                            return;
                        }

                        var fieldId = getElementName(element);

                        if (this.options.fieldId !== fieldId) {
                            this.options.fieldId = fieldId;
                            this.options.duration = $.now();
                            this.options.fieldValue = getElementValue(element);
                        }
                    },

                    onBlurField: function (element) {
                        var fieldId = getElementName(element);
                        var timeStamp = $.now();

                        if (!endsWith(fieldId, "value")) {
                            var owner = getOwner(this.$el, fieldId);
                            if (!owner) {
                                return;
                            }

                            element = owner;
                        }

                        var duration = this.options.duration ? Math.round((timeStamp - this.options.duration) / 1000) : 0;
                        var value = getElementValue(element);
                        var fieldChanged = this.options.fieldId !== fieldId;
                        if (fieldChanged) {
                            this.options.fieldId = fieldId;
                            this.options.duration = $.now();
                            duration = 0;
                        }
                        if (fieldChanged || this.options.fieldValue !== value) {
                            this.options.fieldValue = value;

                            var fieldName = getFieldName(element);
                            var clientEvent = this.buildEvent(fieldId, fieldName, eventIds.fieldCompleted, duration);

                            var validator = this.$el.data("validator");
                            var validationEvents = [];
                            if (validator && !validator.element(element)) {
                                validationEvents = this.checkClientValidation(element, fieldName, validator, duration);
                            }

                            this.trackEvents($.merge([clientEvent], validationEvents));
                        }
                    },

                    buildEvent: function (fieldId, fieldName, eventId, duration) {
                        var fieldIdHidden = getFieldGuid(fieldId) + "ItemId";

                        fieldId = $("input[name=\"" + fieldIdHidden + "\"]").val();

                        return {
                            'formId': this.options.formId,
                            'sessionId': this.options.sessionId,
                            'eventId': eventId,
                            'fieldId': fieldId,
                            'duration': duration,
                            'fieldName': fieldName
                        };
                    },

                    checkClientValidation: function (element, fieldName, validator, duration) {
                        var tracker = this;
                        var events = [];

                        $.each(validator.errorMap,
                            function (key) {
                                if (key === element.name) {
                                    var clientEvent = tracker.buildEvent(key, fieldName, eventIds.fieldError, duration);
                                    events.push(clientEvent);
                                }
                            });

                        return events;
                    },

                    trackEvents: function (events) {
                        $.ajax({
                            type: "POST",
                            url: "/fieldtracking/register",
                            data: JSON.stringify(events),
                            contentType: "application/json"
                        }).done(function (data, textStatus, jqXhr) {
                            if ((jqXhr.statusText === "OK" || jqXhr.statusText === "success") && jqXhr.responseText !== "") {
                                alert(jqXhr.responseText);
                            }
                        });
                    }
                }
            });

    $.fn.track_fxbForms = function (options) {
        return this.each(function () {
            var tracker = $.data(this, "fxbForms.tracking");
            if (tracker) {
                tracker.startTracking();
            } else {
                tracker = new $.fxbFormTracker(this, options);
                $.data(this, "fxbForms.tracking", tracker);
                tracker.startTracking();
            }
        });
    };

    $("form[data-sc-fxb]").track_fxbForms();
});