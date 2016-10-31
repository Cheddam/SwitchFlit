/* global window, navigator, console */
const Vue = require('vue');
const Fuse = require('fuse.js');
const indefiniteArticle = require('indefinite-article');
const { fetch } = require('fetch-ponyfill')();

// eslint-disable-next-line no-new
new Vue({
  el: '#switchflit',

  props: ['dataobject', 'alias'],

  data: {
    visible: false,
    currentState: 'loading', // (loading | ready | error)
    config: {},
    states: {
      loading: {
        title: 'Loading Data',
        description: 'Currently downloading data. You may see incomplete search results.',
      },
      ready: {
        title: 'Ready',
        description: 'Everything is working as expected.',
      },
      error: {
        title: 'Load Failure',
        description: 'Failed to load data. Search is unavailable.',
      },
    },
    records: [],
    fuse: null,
    query: '',
    selectedResult: 0,
  },

  computed: {
    filteredRecords() {
      if (!this.fuse) return [];

      this.fuse.set(this.records);

      return this.fuse.search(this.query);
    },
    currentStateClass() {
      return `switchflit-${this.currentState}`;
    },
    currentStateTitle() {
      return this.states[this.currentState].title;
    },
    currentStateDescription() {
      return this.states[this.currentState].description;
    },
    queryPlaceholder() {
      return `Find ${indefiniteArticle(this.alias)} ${this.alias}...`;
    },
  },

  methods: {
    show() { this.visible = true; window.setTimeout(() => { this.$el.querySelector('input').focus(); }, 0); },
    hide() { this.visible = false; this.query = ''; },

    shiftDown() {
      if (this.selectedResult < this.filteredRecords.length - 1) {
        this.selectedResult = this.selectedResult + 1;
      }
    },
    shiftUp() {
      if (this.selectedResult > 0) {
        this.selectedResult = this.selectedResult - 1;
      }
    },
    selectResult(i) {
      this.selectedResult = i;
    },

    openResult() {
      if (this.filteredRecords.length > 0) {
        window.location = this.filteredRecords[this.selectedResult].link;
      }
    },
  },

  created() {
    fetch(`/switchflit/${this.dataobject}/records`)
      .then((response) => {
        if (!response.ok) {
          response.json().then((parsedBody) => {
            // eslint-disable-next-line no-console
            console.error(`[switchflit] Heads up, something went wrong: ${parsedBody.errors}`);

            this.currentState = 'error';
          });
        } else {
          response.json().then((parsedBody) => {
            this.config = parsedBody.config;
            this.records = parsedBody.items;

            this.fuse = new Fuse(this.records, { keys: ['title'] });

            this.currentState = 'ready';
          });
        }
      })
      .catch((error) => {
        // eslint-disable-next-line no-console
        console.log(`[switchflit] Heads up, something went wrong: ${error.message}`);

        this.currentState = 'error';
      });
  },

  ready() {
    document.addEventListener('keydown', (event) => {
      if (event.keyCode === 27) {
        this.hide();
      } else if (['MacIntel', 'iPhone', 'iPad', 'iPod'].indexOf(navigator.platform) > -1) {
        if(typeof this.config.key_combo_mac !== 'undefined' && this.config.key_combo_mac.length > 0) {
          var keys = this.config.key_combo_mac;
        }
      } else {
        if(typeof this.config.key_combo !== 'undefined' && this.config.key_combo.length > 0) {
          var keys = this.config.key_combo_mac;
        }
      }

      var matchingKeys = 0;

      keys.forEach(function(key) {
        if(parseInt(key) >= 0 && event.keyCode === parseInt(key)) {
          matchingKeys++;
        } else if (
          key.trim() === 'alt' && event.altKey ||
          key.trim() === 'ctrl' && event.ctrlKey ||
          key.trim() === 'meta' && event.metaKey ||
          key.trim() === 'shift' && event.shiftKey
        ) {
          matchingKeys++;
        }
      });

      if(matchingKeys === keys.length) {
        this.show();
        event.preventDefault();
      }
    });

    this.$el.style.visibility = 'visible';
  },
});
