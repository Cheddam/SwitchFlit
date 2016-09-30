<div id="switchflit" class="switchflit-overlay" dataobject="$DataObject" v-show="visible" @click="hide()">
	<div class="switchflit-menu">
		<input v-model="query" type="text" @keyup.enter="openResult" @keyup.down.stop="shiftDown" @keyUp.up.stop="shiftUp">
		<ul>
			<li v-for="(i, record) in filteredRecords | limitBy 5" :class="{ 'switchflit-selected': i === selectedResult }">{{ record.title }}</li>
		</ul>
	</div>
</div>

<% require css('switchflit/css/dist/switchflit.css') %>
<% require javascript('switchflit/js/dist/switchflit.js') %>
