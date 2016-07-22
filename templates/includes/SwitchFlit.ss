<div id="switchflit" model="$Model" v-show="visible">
	<input v-model="query" type="text" @keyup.enter="openResult">
	<ul>
		<li v-for="record in filteredRecords | limitBy 5">{{ record.Name }}</li>
	</ul>
</div>

<% require css('switchflit/css/dist/switchflit.css') %>
<% require javascript('switchflit/js/dist/switchflit.js') %>
