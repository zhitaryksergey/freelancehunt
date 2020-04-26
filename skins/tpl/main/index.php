<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<link rel='stylesheet' id='jquery-ui-style-css'  href='https://science.bio/wp-content/plugins/woocommerce/assets/css/jquery-ui/jquery-ui.min.css?ver=3.8.1' media='all' />
<link rel='stylesheet' id='datatables_list_styles-css'  href='https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css?ver=1.10.16' media='all' />
<link rel='stylesheet' id='datatables_buttons_list_styles-css'  href='https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css?ver=1.10.16' media='all' />
<link rel='stylesheet' id='datatables_css_select_dataTables-css'  href='https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css?ver=1.10.16' media='all' />
<script src='https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js?ver=1.10.16'></script>
<script src='https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js?ver=1.10.16'></script>
<script src='https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js?ver=1.10.16'></script>
<div class="projects">
    <table id="projects">
        <thead>
        <tr>
            <th></th>
            <th>Проект</th>
            <th></th>
            <th></th>
            <th>Бюджет</th>
            <th></th>
            <th>Закакзчик</th>
            <th></th>
            <th>Логин</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        var table = jQuery('#projects').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [10, 20, 50],
            order: [[ 1, "desc" ]],
            ajax: {
                url: "<?= IRB_HOST ?>/ajax/ajax.php?page=project&mod=ajax",
                type: "POST",
            },
            columns: [
                {
                    data: "id",
                    visible: false,
                },
                {
                    data: "name",
                    targets: 0,
                    render: function ( data, type, row, meta ) {
                        if(type === 'display'){
                            data = '<a href="' + encodeURIComponent(row.link) + '" target="_blank">(' + row.id + ') ' + row.name +'</a>';
                        }
                        return data;
                    }
                },
                {
                    data: "description",
                    visible: false,
                },
                {
                    data: "link",
                    visible: false,
                },
                {
                    data: "budget",
                    targets: 1,
                    render: function ( data, type, row, meta ) {
                        if(type === 'display'){
                            data = row.budget + ' ' + row.currency;
                        }

                        return data;
                    }
                },
                {
                    data: "currency",
                    visible: false,
                },
                {
                    data: "first_name",
                    targets: 2,
                    render: function ( data, type, row, meta ) {
                        if(type === 'display'){
                            data = row.first_name + ' ' + row.last_name;
                        }

                        return data;
                    }
                },
                {
                    data: "last_name",
                    visible: false,
                },
                {data: "login"},
            ],
            buttons: [
            ],
        });
    });
</script>