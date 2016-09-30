/* global window, navigator */
const Vue = require('vue');
const Fuse = require('fuse.js');

// eslint-disable-next-line no-new
new Vue({
  el: '#switchflit',

  props: ['dataobject'],

  data: {
    visible: false,
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

    openResult() {
      if (this.filteredRecords.length < 1) return true;

      window.location = this.filteredRecords[this.selectedResult].link;
      return false;
    },
  },

  created() {
    fetch(`/switchflit/${this.dataobject}/records`)
      .then(response => response.json())
      .then((records) => {
        this.records = records;

        this.fuse = new Fuse(this.records, { keys: ['title'] });
      });
  },

  ready() {
    document.addEventListener('keydown', (event) => {
      if (event.keyCode === 27) {
        this.hide();
      } else if ((navigator.platform === 'MacIntel' && event.metaKey && event.keyCode === 75) || (event.ctrlKey && event.keyCode === 75)) {
        this.show();
      }
    });

    this.$el.style.visibility = 'visible';
  },
});
