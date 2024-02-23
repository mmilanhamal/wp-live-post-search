window.addEventListener("load", function(event) {
  var j = jQuery.noConflict();

  var vm = new Vue({
    el: '#wpls-search',
    data: {
      search_val: '',
      results: []
    },
    watch: {
      search_val: function(newValue){
        this.searchcall()
      }
    },
    methods: {
      searchcall: function (newValue) {
        // And here is our jQuery ajax call
        j.ajax({
          type:"POST",
          url: WPLS.ajaxurl,
          data: {
          action:'wpls_ajax_search_main',
          search_string:vm.search_val
          },
          success:function(response){
            vm.results = response;
          },
          error: function(error){
            vm.results = 'There seems to be an error with this search.';
          }
        });
      }
    }
  })
});