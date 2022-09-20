$(document).ready(function(){
$('#data_table').Tabledit({
deleteButton: false,
editButton: false,
columns: {
identifier: [0, 'ID'],
editable: [[1, 'Number'], [2, 'Name'], [3, 'Start'], [4, 'End']], [5, 'TrackID']], [6, 'Status']]
},
hideIdentifier: true,
url: '#'
});
});
{"mode":"full","isActive":false}