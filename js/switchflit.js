require('es6-promise').polyfill();

var Vue = require('vue')
var Fuse = require('fuse.js')

window.switchflit = new Vue({
	el: '#switchflit',

	props: ['model'],

	data: {
		visible: false,
		records: [],
		fuse: null,
		query: ''
	},

	computed: {
		filteredRecords() {
			if (!this.fuse) return []

			this.fuse.set(this.records)

			return this.fuse.search(this.query)
		}
	},

	methods: {
		show() { this.visible = true; window.setTimeout(() => { this.$el.querySelector('input').focus() }, 0) },
		hide() { this.visible = false; this.query = '' },

		openResult() {
			if (this.filteredRecords.length < 1) return true

			window.location = this.filteredRecords[0].URL
		}
	},

	created() {
		fetch(`/switchflit/${this.model}/records`).then((response) => {
			return response.json()
		}).then((records) => {
			this.records = records

			this.fuse = new Fuse(this.records, { keys: ['Name'] })
		})
	},

	ready() {
		this.$el.style.visibility = 'visible'
	}
})

document.addEventListener('keydown', (event) => {
	if (event.keyCode == 27) {
		window.switchflit.hide()
	} else if (event.metaKey && event.keyCode == 75) {
		window.switchflit.show()
	}
})