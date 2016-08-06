<div id="switchflit" class="switchflit-overlay" model="$Model" v-show="visible" @click="hide()">
	<div class="switchflit-menu">
		<input v-model="query" type="text" @keyup.enter="openResult">
		<ul>
			<li v-for="record in filteredRecords | limitBy 5">{{ record.Name }}</li>
		</ul>
	</div>
</div>

<% require css('switchflit/css/dist/switchflit.css') %>
<% require javascript('switchflit/js/dist/switchflit.js') %>
