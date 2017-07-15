<script>
    var cancel_string = $("#btn-cancel").val();
    var delete_string = $("#btn-delete").val();

    function deleteItem(id, id_prefix) {
        event.preventDefault();
        $( "#dialog" ).dialog({
            buttons: [
                {
                    text: cancel_string,
                    class: "btn btn-primary",
                    click: function() {
                        $(this).dialog("close");
                    }
                },
                {
                    text: delete_string,
                    class: "btn btn-primary red",
                    click: function() {
                        $("#" + id_prefix + "-" + id).submit();
                    }
                }
            ]
        });
    }
</script>