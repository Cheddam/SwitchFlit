<div id="switchflit" class="switchflit-overlay" :class="currentStateClass" dataobject="$DataObject" alias="<% if $Alias %>$Alias<% else %>$DataObject<% end_if %>" v-show="visible" @click.self="hide">
    <div class="switchflit-ui">
        <div class="switchflit-menu">
            <header class="switchflit-heading">
                <h5 class="switchflit-title">Switch {{ alias }}</h5>
                <small class="switchflit-state" v-if="currentState !== 'ready'" :class="currentStateClass" :title="currentStateDescription">{{ currentStateTitle }}</small>
            </header>

            <input class="switchflit-query"
                   :placeholder="queryPlaceholder"
                   v-model="query" type="text"
                   :disabled="currentState === 'error'"
                   @keyup.enter="openResult"
                   @keyup.down.stop="shiftDown"
                   @keyUp.up.stop="shiftUp">
        </div>

        <ul class="switchflit-results"
            v-if="filteredRecords.length > 0">
            <li class="switchflit-result"
                v-for="(i, record) in filteredRecords | limitBy 5"
                :class="{ 'switchflit-selected': i === selectedResult }"
                @mouseover="selectResult(i)"
                @click="openResult">
                <p class="switchflit-result-title">{{ record.title }}</p>
                <p class="switchflit-result-details">{{ record.link }}</p>
            </li>
        </ul>
    </div>
</div>

<% require css('switchflit/css/dist/switchflit.css') %>
<% require javascript('switchflit/js/dist/switchflit.js') %>
