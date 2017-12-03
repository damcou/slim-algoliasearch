'use strict';
/* global instantsearch */

/* Initialize instantsearch */
var search = instantsearch({
  appId: '53ITHX8IH4',
  apiKey: 'bd72a5e144d53b9a20039becab2638f8',
  indexName: 'appstore'
});

/* Add searchbox */
search.addWidget(
  instantsearch.widgets.searchBox({
    container: '#q',
    placeholder: 'Search an app'
  })
);

/* Add statsbar */
search.addWidget(
  instantsearch.widgets.stats({
    container: '#stats'
  })
);

/* Add hits */
var hitTemplate =
    '<article class="hit">' +
    '<div class="app-picture-wrapper">' +
    '<div class="app-picture"><img src="assets/img/placeholder.jpg" /></div>' +
    '</div>' +
    '<div class="app-desc-wrapper">' +
    '<div class="app-name">{{{_highlightResult.name.value}}}</div>' +
    '<div class="app-type">{{{_highlightResult.category.value}}}</div>' +
    '<div class="app-link"><a target="_blank" href="{{{_highlightResult.link.value}}}">See the application in the Apple store ></a></div>' +
    '</div>' +
    '</article>';

var noResultsTemplate =
    '<div class="text-center">No results found matching <strong>{{query}}</strong>.</div>';

search.addWidget(
  instantsearch.widgets.hits({
    container: '#hits',
    hitsPerPage: 16,
    templates: {
      empty: noResultsTemplate,
      item: hitTemplate
    },
    transformData: function(hit) {
      hit.stars = [];
      for (var i = 1; i <= 5; ++i) {
        hit.stars.push(i <= hit.rating);
      }
      return hit;
    }
  })
);


/* Add pagination */
search.addWidget(
  instantsearch.widgets.pagination({
    container: '#pagination',
    cssClasses: {
      active: 'active'
    },
    labels: {
      previous: '<i class="fa fa-angle-left fa-2x"></i> Previous page',
      next: 'Next page <i class="fa fa-angle-right fa-2x"></i>'
    },
    showFirstLast: false
  })
);

/* Add category facet */

var facetTemplateCheckbox =
    '<a href="javascript:void(0);" class="facet-item">' +
    '<input type="checkbox" class="{{cssClasses.checkbox}}" value="{{label}}" {{#isRefined}}checked{{/isRefined}} />{{label}}' +
    '<span class="facet-count">({{count}})</span>' +
    '</a>';

search.addWidget(
    instantsearch.widgets.refinementList({
        container: '#category',
        attributeName: 'category',
        operator: 'or',
        limit: 30,
        templates: {
            item: facetTemplateCheckbox,
            header: '<div class="facet-title">Categories</div class="facet-title">'
        }
    })
);

/* Add sort by selector */
search.addWidget(
  instantsearch.widgets.sortBySelector({
    container: '#sort-by-selector',
    indices: [
      {name: 'appstore', label: 'Rank desc.'},
      {name: 'appstore_rank_asc', label: 'Rank asc.'}
    ],
    label:'sort by'
  })
);

/* Start the search */
search.start();
