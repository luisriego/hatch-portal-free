(function($) {
    var adapters = $.validator.unobtrusive.adapters;
    adapters.fxbAddNumberVal = function (adapterName, attribute, ruleName) {
        attribute = attribute || "val";
        ruleName = ruleName || adapterName;
        this.add(adapterName, [attribute], function(options) {
                var attrVal = options.params[attribute];
                if ((attrVal || attrVal === 0) && !isNaN(attrVal)) {
                    options.rules[ruleName] = Number(attrVal);
                }
                if (options.message) {
                    options.messages[ruleName] = options.message;
                }
            });
    };

    adapters.fxbAddMinMax = function(adapterName, minRuleName, maxRuleName, minAttribute, maxAttribute) {
        minAttribute = minAttribute || "min";
        maxAttribute = maxAttribute || "max";
        this.add(adapterName, [minAttribute, maxAttribute], function(options) {
                if (options.params[minAttribute] && options.params[maxAttribute]) {
                    if (!options.rules.hasOwnProperty(minRuleName)) {
                        if (options.message) {
                            options.messages[minRuleName] = options.message;
                        }
                    }
                    if (!options.rules.hasOwnProperty(maxRuleName)) {
                        if (options.message) {
                            options.messages[maxRuleName] = options.message;
                        }
                    }
                }
            });
    };

    adapters.addBool("ischecked", "required");

    $.validator.addMethod(
        "daterange",
        function(value, element, params) {
            return this.optional(element) || (value >= params.min && value <= params.max);
        });

    adapters.add(
        "daterange",
        ["min", "max"],
        function(options) {
            var params = {
                min: options.params.min,
                max: options.params.max
            };
            options.rules["daterange"] = params;
            options.messages["daterange"] = options.message;
        });

    adapters.addSingleVal("filesize", "max");
    $.validator.addMethod(
        "filesize",
        function (value, element, max) {
            if (!this.optional(element)) {
                for (var i = 0; i < element.files.length; i++) {
                    if (element.files[i].size > max) {
                        return false;
                    }
                }
            }
            return true;
        });

    adapters.addSingleVal("filecount", "max");
    $.validator.addMethod(
        "filecount",
        function (value, element, max) {
            if (!this.optional(element)) {
                    if (element.files.length > max) {
                        return false;
                    }
            }
            return true;
        });

    adapters.addSingleVal("filetype", "allowedcontenttypes");
    $.validator.addMethod(
        "filetype",
        function (value, element, allowedContentTypes) {
            if (!this.optional(element)) {
                var allowedContentTypesArray = allowedContentTypes.split(",").filter(function (s) {
                    // Remove empty entries
                    return s !== "";
                });
                if (allowedContentTypesArray.length) {
                    for (var i = 0; i < element.files.length; i++) {
                        var file = element.files[i];
                        var isValid = false;
                        for (var j = 0; j < allowedContentTypesArray.length; j++) {
                            var allowedContentType = allowedContentTypesArray[j];
                            if (allowedContentType.indexOf("/") !== -1) {
                                // MIME type comparison if there is a slash "/"
                                isValid = allowedContentType.toLowerCase() === file.type.toLowerCase();
                            } else {
                                // File extension comparison
                                isValid = allowedContentType.toLowerCase() === "." + file.name.split(".").pop().toLowerCase();
                            }

                            if (isValid) {
                                break;
                            }
                        }

                        if (!isValid) {
                            return false;
                        }
                    }
                }
            }
            return true;
        });

    adapters.fxbAddNumberVal("min");
    adapters.fxbAddNumberVal("max");
    adapters.fxbAddNumberVal("step");

    adapters.fxbAddMinMax("range", "min", "max");
    adapters.fxbAddMinMax("length", "minlength", "maxlength");
    adapters.fxbAddMinMax("daterange", "min", "max");
})(jQuery);
