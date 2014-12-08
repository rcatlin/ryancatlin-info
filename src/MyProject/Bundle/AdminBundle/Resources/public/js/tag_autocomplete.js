$(document).ready(
    function() {
        // Selectors
        var selectors = {
            'articleTags':  '#article_tags',
            'labels':       'label',
            'activeTags':   '#active_article_tags',
            'newTags':      '#article_new_tags',
            'autocomplete': '#article_tags_autocomplete'
        };

        // Elements
        var $articleTags = $(selectors.articleTags);
        var $labels = $articleTags.find(selectors.labels);
        var $newTags = $(selectors.newTags);
        var $activeTags = $(selectors.activeTags);
        var $autocompleteSelector = $(selectors.autocomplete);
        var $autocomplete = $(selectors.autocomplete);

        var tag_ac = {
            tagData: {
                'active' : {},
                'inactive': {},
                'new': [],
            },

            // Autocomplete source set data
            dataSourceSet: [],

            selectionFlag: false,
            emptyActiveTagsText: '',

            refreshTags: function () {
                // New Tags
                Object
                    .keys(
                        tag_ac.tagData['new']
                    )
                    .forEach(
                        function (key) {
                            var name = tag_ac.tagData['new'][key];
                            tag_ac.appendTag('new', undefined, name);
                        }
                    );

                // Active Tags
                Object
                    .keys(
                        tag_ac.tagData['active']
                    )
                    .forEach(
                        function (key) {
                            var name = tag_ac.tagData['active'][key];
                            tag_ac.appendTag('active', key, name);
                        }
                    )
                ;

                tag_ac.bindTagButtonClicks();
            },
            refreshNewTags: function () {
                $newTags.val(
                    tag_ac.tagData['new'].join(',')
                );
            },
            evaluateDataSourceSet: function () {
                // Clear data source set by setting as empty array
                tag_ac.dataSourceSet = [];

                // Iterate through inactive tag ids
                // and push object to data source set
                Object
                    .keys(
                        tag_ac.tagData['inactive']
                    )
                    .forEach(
                        function(tagId) {
                            var tagName = tag_ac.tagData['inactive'][tagId];
                            tag_ac.addToDataSourceSet(tagId, tagName);
                        }
                    )
                ;
                $autocomplete.autocomplete(
                    'option',
                    'source',
                    tag_ac.dataSourceSet
                );
            },
            addToDataSourceSet: function (tagId, tagName){
                tag_ac.dataSourceSet.push(
                    {
                        'name': tagId,
                        'label': tagName
                    }
                );
            },
            appendTag: function (type, key, name) {
                // Check if we should clear tag area
                // before adding first button
                var $buttons = $activeTags.find('button');
                if ($buttons.length <= 0) {
                    // Save empty text
                    tag_ac.emptyActiveTagsText = $activeTags.html();
                    // Clear text
                    $activeTags.html('');
                }

                // css button 'class' attribute
                var classes = 'btn btn-info';
                if (type == 'new') {
                    classes = 'btn btn-success';
                }

                $activeTags.append(
                    '<button' 
                    + ' class="'
                    + classes
                    + '" data-tag-type="'
                    + type
                    + '" data-tag-id="'
                    + key
                    + '" data-tag-name="'
                    + name
                    + '" type="button">'
                    + '<span class="fa fa-times-circle">'
                    + '&nbsp;'
                    + name
                    + '</span>'
                    + '</button>'
                );

                tag_ac.bindTagButtonClicks();
            },
            bindAutocompleteFormSubmission: function () {
                /** 
                 * Prevents enter key in autocomplete field
                 * from triggering form submission.
                 *
                 * Handles addition of tags when user does
                 * not use autocomplete dropdown.
                 */
                $autocomplete.bind(
                    'keyup keydown keypress',
                    function(event) {
                        if (event.keyCode == 13) {
                            event.preventDefault();
                            
                            var eventTarget = event.currentTarget;
                            var tagName = eventTarget.value;

                            if (
                                event.type == 'keyup'
                                && eventTarget.id == 'article_tags_autocomplete'
                                && tagName.length > 0
                            ) {
                                var existing = false;
                                // Check if tag matches existing or new tags
                                if (
                                    tag_ac.isExistingActiveTagName(tagName)
                                    || tag_ac.isExistingNewTagName(tagName)
                                ) {
                                    // Clear the autocomplete text.
                                    tag_ac.clearAutocompleteText()

                                    return;
                                } else if (tag_ac.isExistingInactiveTagName(tagName)) {
                                    // Find tagId
                                    var tagId = tag_ac.findExistingInactiveTagIdByName(tagName);

                                    if (tagId !== undefined) {
                                        tag_ac.convertInactiveTagToActiveTag(tagId, tagName);
                                        tag_ac.clearAutocompleteText();
                                    } else {
                                        alert('An error occurred adding tag:' + tagName);
                                    }
                                } else {
                                    // Brand new tag!
                                    // Add to new tags
                                    tag_ac.tagData['new'].push(tagName);
                                    tag_ac.appendTag('new', undefined, tagName);
                                    tag_ac.clearAutocompleteText();
                                    tag_ac.refreshNewTags();
                                }
                            }
                        }
                    }
                );
            },
            initAutocomplete: function () {
                // Init Autocomplete
                $autocomplete.autocomplete({
                    source: tag_ac.dataSourceSet,
                    close:  tag_ac.autocompleteClose,
                    select: tag_ac.autocompleteSelect
                });
            },
            autocompleteClose: function (event, ui) {
                if (tag_ac.isSelectionFlagged()) {
                    $autocomplete.val('');
                    tag_ac.unflagSelection();
                }
            },
            autocompleteSelect: function (event, ui) {
                var tagId = ui.item.name;
                var tagName = ui.item.label;

                tag_ac.flagSelection()

                // Clear text
                tag_ac.clearAutocompleteText();
                
                tag_ac.convertInactiveTagToActiveTag(tagId, tagName);
            },
            clearAutocompleteText: function()
            {
                $autocomplete.val('');
            },
            convertInactiveTagToActiveTag: function (tagId, tagName) {
                // Remove tag from inactive tags
                if (tag_ac.tagData['inactive'].hasOwnProperty(tagId)) {
                    delete tag_ac.tagData['inactive'][tagId];
                }

                // Add to active tags data
                tag_ac.tagData['active'][tagId] = tagName

                // Add to active tags area
                tag_ac.appendTag('active', tagId, tagName);

                // Check active tag in article_tags
                tag_ac.checkActiveTag(tagId);

                // Reset source set
                tag_ac.evaluateDataSourceSet();
            },
            isExistingActiveTagName: function (tagName) {
                var exists = false;

                // Check active
                Object
                    .keys(
                        tag_ac.tagData['active']
                    )
                    .forEach(
                        function (key) {
                            var name = tag_ac.tagData['active'][key];
                            if (name.toLowerCase() == tagName.toLowerCase()) {
                                exists = true;
                            }
                        }
                    );
                return exists;
            },
            isExistingInactiveTagName: function (tagName) {
                return tag_ac.findExistingInactiveTagIdByName(tagName) !== undefined;
            },
            isExistingNewTagName: function (tagName) {
                var exists = false;

                // Check new
                Object
                    .keys(
                        tag_ac.tagData['new']
                    )
                    .forEach(
                        function (key) {
                            var name = tag_ac.tagData['new'][key];
                            if (name.toLowerCase() == tagName.toLowerCase()) {
                                exists = true;
                            }
                        }
                    );

                return exists;
            },
            findExistingInactiveTagIdByName: function (tagName)
            {
                var tagId = undefined;

                // Check inactive
                Object
                    .keys(
                        tag_ac.tagData['inactive']
                    )
                    .forEach(
                        function (key) {
                            var name = tag_ac.tagData['inactive'][key];
                            if (name.toLowerCase() == tagName.toLowerCase()) {
                                tagId = key;
                            }
                        }
                    );

                return tagId;
            },
            findExistingNewTagKeyByName: function (tagName)
            {
                var newKey = undefined;

                // Check inactive
                Object
                    .keys(
                        tag_ac.tagData['new']
                    )
                    .forEach(
                        function (key) {
                            var name = tag_ac.tagData['new'][key];
                            if (name.toLowerCase() == tagName.toLowerCase()) {
                                newKey = key;
                            }
                        }
                    );

                return newKey;
            },
            isSelectionFlagged: function () {
                return tag_ac.selectionFlag;
            },
            flagSelection: function () {
                tag_ac.selectionFlag = true;
            },
            unflagSelection: function() {
                tag_ac.selectionFlag = false;
            },
            bindTagButtonClicks: function () {
                $activeTags.find('button').bind(
                    'click',
                    tag_ac.onTagButtonClicked
                );
            },
            onTagButtonClicked: function(event) {
                var button = $(event.currentTarget);
                var tagType = button.data('tag-type');
                var tagId = button.data('tag-id');
                var tagName = button.data('tag-name');

                if (tagType == 'active') {
                    tag_ac.tagData['inactive'][tagId] = tagName;
                    // Re-evaluate data source set for autocompletions
                    tag_ac.evaluateDataSourceSet();
                } else if (tagType == 'new') {
                    var newKey = tag_ac.findExistingNewTagKeyByName(tagName);

                    if (newKey !== undefined) {
                        delete tag_ac.tagData['new'][newKey];
                        tag_ac.refreshNewTags();
                    }
                }

                button.remove();

                // Check if there are no tag buttons
                var buttons = $activeTags.find('button');
                if (buttons.length <= 0) {
                    $activeTags.html(tag_ac.emptyActiveTagsText);
                }
            },
            checkActiveTag: function (tagId) {
                var $tagCheckbox = $articleTags.find('#article_tags_' + tagId).first();
                $tagCheckbox.attr('checked', 'checked');
            },

            init: function () {
                if ($labels.length > 0) {
                    // Populate all and ids
                    for (var i = 0; i < $labels.length; i++) {
                        var curr = $($labels[i]).first();

                        var tagName = curr.html();
                        var labelId = curr.attr('for');

                        // Discover active and inactive tags
                        var elem = $('#' + labelId);
                        var tagId = elem.val();
                        
                        if (elem && elem.checked) {
                            tag_ac.tagData['active'][tagId] = tagName;
                        } else {
                            tag_ac.tagData['inactive'][tagId] = tagName;
                            tag_ac.addToDataSourceSet(tagId, tagName);
                        }

                        // Add Active tags to tag area
                        tag_ac.refreshTags();
                    }
                }

                tag_ac.bindAutocompleteFormSubmission();
                tag_ac.initAutocomplete();
            }
        }

        // Init tag autocomplete object
        tag_ac.init();
    }
);