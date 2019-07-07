<template>
  <div>
      <div class="images">
        <input type="hidden" name="_method" value="PUT">
        <a v-for="result in results" :key="result.id" v-if="result.url">
            <img :src="result.url" :alt="result.title" />
            <span @click="fav(result.id)">
                <i class="material-icons">favorite</i>
                <abbr v-if="result.favs">{{ result.favs }}</abbr>
            </span>
        </a>
        <a v-for="result in results" :key="result.id" v-if="result.name">
            {{ result.name }}<br />
            <i class="material-icons amaranth">favorite</i> {{ result.favs }} Likes
        </a>
      </div>
      <paginate
        v-model="page"
        :page-count="totalPages"
        :margin-pages="2"
        :page-range="5"
        :container-class="'ui pagination menu'"
        :page-link-class="'item'"
        :prev-link-class="'item'"
        :next-link-class="'item'"
        :break-view-link-class="'break-view-link'"
        :no-li-surround="true"
        :page-class="'page-item'"
        :click-handler="paginateCallback"
      ></paginate>
  </div>
</template>

<script>
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios)
export default {
	data () {
		return {
		    page: 1,
            totalPages: 1,
			results: [],
		}
	},
  mounted() {
      this.fetchData();
      Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
      Vue.prototype.$weekday = document.querySelector("meta[name='weekday']").getAttribute('content');
      Vue.prototype.$weekdayString = '&weekday=0';
      if (this.$weekday) Vue.prototype.$weekdayString = '&weekday=1';
  },
  methods: {
      fav(id) {
            if (this.$userId) {
                axios.post("fav-" + id, { userId: this.$userId }).then((response) => {
                    console.log(response);
                    console.log(id);
                });
            } else {
                alert("Not logged in.");
            }
      },
      fetchData() {
          Vue.prototype.$weekday = document.querySelector("meta[name='weekday']").getAttribute('content');
          if (this.$weekday) Vue.prototype.$weekdayString = '&weekday=1';

          axios.get('json?page=1' + this.$weekdayString)
          .then(response => {
                this.results = response.data;
                this.totalPages = response.data.totalPages;
          })
      },
      paginateCallback: function(pageNumber) {
          axios.get("json?page="+ pageNumber + this.$weekdayString)
          .then((response) => {
              this.results = response.data
          });
      }
  }
}
</script>

