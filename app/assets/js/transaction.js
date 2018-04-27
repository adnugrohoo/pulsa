var pages=1;
function getTransactionData(page,mode,filter){
  $.getJSON(
    '../dummy/get_flight_transaction',
    {
      page:page,
      mode:mode,
      filter:filter
    },
    function(data) {
      console.log(data);
    });
}
$( document ).ready(function() {
    getTransactionData(pages,'filter',null);
});
