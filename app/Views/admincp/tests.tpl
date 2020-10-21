{* SMARTY *}

{extends "admincp/template/admintemplate.tpl"}

{block name="content" nocache}
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> TESTS
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>NAME</th>
                                <th>PRICE</th>
                                <th>CATEGORIES</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach from=$tests item=$test}
                                <tr>
                                    <td>{$test.id}</td>
                                    <td>{$test.name}</td>
                                    <td>{$test.price}</td>
                                    <td>{$test.category}</td>
                                    <td>
                                        <button class="btn btn-success btnEdit" data-test="{$test.id}"
                                                data-name="{$test.name}" data-price="{$test.price}"
                                                data-desc="{$test.description}">EDIT
                                        </button>
                                        <button class="btn btn-danger btnDelete" data-test="{$test.id}">DELETE
                                        </button>
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box_form">
                <h3>Add Test</h3>
                <div id="addTestLoader"></div>
                <form method="post" class="ajaxForm" data-loader="addTestLoader"
                      data-url="{$siteurl}adminAddTest" id="frmAddTest">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NAME</label>
                                <input type="text" name="testName" id="frmTestName" class="form-control"
                                       placeholder="Test Name">
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" name="testPrice" id="frmtestPrice" class="form-control"
                                       placeholder="Price of this test">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea id="testDescription" name="testDescription"></textarea>
                            </div>
                            <div class="form-group">
                                <label>ACTION</label><br>
                                <button class="btn btn-primary " style="width:30%" id="btnAddTest">Add Test
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Categories</label>
                                <select multiple class="form-control" style="height:400px" id="testCategories"
                                        name="testcategories[]">
                                    {foreach from=$categories item=$cat}
                                        <option value="{$cat.id}">{$cat.name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.container-fluid-->
    </div>
    <!-- Update Modal-->
    <div class="modal fade" id="modalEDIT" tabindex="-1" role="dialog" aria-labelledby="modalEDITLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEDITLabel">EDIT TEST</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" class="ajaxForm" data-loader="updateLoader" id="editTestFrm"
                      data-url="{$siteurl}adminUpdateTest">
                    <div class="modal-body">
                        <div id="updateLoader"></div>

                        <input type="hidden" value="0" name="edittestID" id="edittestID">
                        <div class="box_form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NAME</label>
                                        <input type="text" id="editTestName" name="editTestName" class="form-control"
                                               placeholder="Test Name">
                                    </div>
                                    <div class="form-group">
                                        <label>PRICE</label>
                                        <input type="number" id="editTestPrice" name="editTestPrice"
                                               class="form-control"
                                               placeholder="Test Price">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea id="edittestDescription" name="edittestDescription"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Categories</label>
                                        <select multiple class="form-control" style="height:400px"
                                                id="edittestcategories"
                                                name="edittestcategories[]">
                                            {foreach from=$categories item=$cat}
                                                <option value="{$cat.id}">{$cat.name}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary btnUpdateTest" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{/block}

{block name="footer" append}
    <script>
        $(function () {
            CKEDITOR.replace('testDescription');
            CKEDITOR.replace('edittestDescription');

            let dataTable = $('#dataTable').DataTable({
                "pageLength": 5,
                lengthMenu: [[5, 10], [5, 10]]
            });

            $('#dataTable').on('draw.dt', function () {
                RegisterEvents();
            });

            RegisterEvents();

            function RegisterEvents() {

                $('.btnEdit').on('click', function () {
                    let testID = $(this).data('test');
                    let testPrice = $(this).data('price');
                    let testName = $(this).data('name');
                    let desc = $(this).data('desc');

                    $('#edittestID').val(testID);
                    $('#editTestName').val(testName);
                    $('#editTestPrice').val(testPrice);
                    CKEDITOR.instances.edittestDescription.setData(desc);
                    $('#modalEDIT').modal();
                });


                $('#frmAddTest').bind('success', function (e, id) {
                    if ($(e).name == 'editTestFrm') return;
                    alert($(e).name);
                    let name = $('#frmTestName').val();
                    let price = $('#frmtestPrice').val();
                    let categories = $('#testCategories').find(':selected').text() || '';
                    let desc = $('#testDescription').val();

                    let buttons = '  <button class="btn btn-success btnEdit" data-test="' + id + '"\n' +
                        '                                                data-name="' + name + '" data-price="' + price + '"\n' +
                        '                                                data-desc="' + desc + '">EDIT\n' +
                        '                                        </button>\n' +
                        '                                        <button class="btn btn-danger btnDelete" data-test="' + id + '">DELETE\n' +
                        '                                        </button>'
                    dataTable.row.add([
                        id,
                        name,
                        price,
                        categories,
                        buttons
                    ]).draw(false);
                });
            }
        });
    </script>
{/block}