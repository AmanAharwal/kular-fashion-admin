<template>
    <table id="product-table" data-selected-articles="" class="table table-bordered dt-responsive nowrap w-100">
        <thead>
            <tr>
                <th>
                    <div class="form-check form-check-primary mb-3">
                        <input class="form-check-input" type="checkbox" id="select-all">
                    </div>
                </th>
                <th>Article Code</th>
                <th>Description</th>
                <th>Product Type</th>
                <th>Brand</th>
                <th>Price</th>
            </tr>
        </thead>
    </table>
</template>


<script>
export default {
    mounted() {
        const table = $('#product-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/get-products',
                data: function (d) {
                    d.page = Math.floor(d.start / d.length) + 1;
                }
            },
            columns: [
                {
                    title: `<div class="form-check form-check-primary">
                            <input class="form-check-input" type="checkbox" id="select-all">
                        </div>`,
                    orderable: false,
                    render: function (data, type, row) {
                        let selectedArticles = $('#product-table').attr('data-selected-articles').split(',');
                        let checked = selectedArticles.includes(String(row.id)) ? 'checked' : '';

                        if(!checked && !row.barcodes_printed_for_all){
                            checked = 'checked';
                        }

                        return `<div class="form-check form-check-primary">
                                <input class="form-check-input select-row" type="checkbox" value="${row.id}" ${checked}>
                            </div>`
                    }
                },
                { title: "Article Code", data: 'article_code' },
                { title: "Description", data: 'short_description' },
                { title: "Brand", data: 'brand.name' },
                { title: "Product Type", data: 'product_type.product_type_name' },
                { title: "Price", data: 'mrp' },
            ],
            order: [[1, 'asc']],
            drawCallback: function(settings) {
                // Call expandRow for each row after table is drawn
                table.rows().every(function() {
                    const rowData = this.data();
                    const row = this.node();
                    expandRow($(row), rowData);
                });
            }
        });

        // Handle row expansion on clicking any td (except the checkbox column)
        $('#product-table').on('change', '.select-row', (e) => {
            const checkbox = $(e.target);
            const row = checkbox.closest('tr');
            const rowData = table.row(row).data();
            const expandedRow = row.next('.expanded-row');

            if (checkbox.prop('checked')) {
                expandRow(row, rowData);
            } else {
                expandedRow.remove();
            }
        });

        $('table').on('change', '#select-all', (event) => {
            var checkboxes = $('#product-table .select-row');

            if (event.target.checked) {
                checkboxes.each((_, checkbox) => {
                    const row = $(checkbox).closest('tr');
                    const rowData = $(checkbox).closest('table').DataTable().row(row).data();
                    expandRow(row, rowData);
                });
            } else {
                $('#product-table .expanded-row').remove();
            }
        });

        $('#product-table').on('click', 'tbody tr', (e) => {
            if (e.target.tagName !== 'TD') return;
            const row = $(e.currentTarget);
            const rowData = table.row(row).data();
            const nextRow = row.next('.expanded-row');

            const checkbox = row.find('.select-row');
            checkbox.prop('checked', 'checked');

            if (nextRow.length) {
                nextRow.remove();
            } else {
                expandRow(row, rowData);
            }
        });
    },
};
</script>