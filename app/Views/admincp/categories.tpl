{* SMARTY *}

{extends "admincp/template/admintemplate.tpl"}

{block name="content" nocache}
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> CATEGORIES
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>NAME</th>
                                <th>ORDER</th>
                                <th>FRONT PAGE</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach from=$categories item=$category}
                                <tr id="category{$category.id}">
                                    <td>{$category.id}</td>
                                    <td>{$category.name}</td>
                                    <td>{$category.order}</td>
                                    <td class="frontPage">{$category.frontpage}</td>
                                    <td>
                                        <button class="btn btn-success btnEdit" data-category="{$category.id}"
                                                data-name="{$category.name}" data-order="{$category.order}"
                                                data-frontpage="{$category.frontpage}">EDIT
                                        </button>
                                        <button class="btn btn-danger btnDelete" data-category="{$category.id}">DELETE
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
                <div id="addCatLoader"></div>
                <form method="post" class="ajaxForm" data-loader="addCatLoader"
                      data-url="{$siteurl}adminAddCategory">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NAME</label>
                                <input type="text" name="categoryName" id="frmcategoryName" class="form-control"
                                       placeholder="Category Name">
                            </div>
                            <div class="form-group">
                                <label>Order</label>
                                <input type="number" name="categoryOrder" id="frmcategoryOrder" class="form-control"
                                       placeholder="Order in the list">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>FrontPage</label>
                                <select class="form-control" id="categoryfrontPage" name="frontPage">
                                    <option value="1">YES</option>
                                    <option value="0" selected>NO</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>ACTION</label><br>
                                <button class="btn btn-primary " style="width:30%" id="btnAddCategory">Add Category
                                </button>
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
                    <h5 class="modal-title" id="modalEDITLabel">EDIT CATEGORY</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" class="ajaxForm" data-loader="updateLoader" id="addCategoryFrm"
                      data-url="{$siteurl}adminUpdateCategory">
                    <div class="modal-body">
                        <div id="updateLoader"></div>

                        <input type="hidden" value="0" name="categoryID" id="categoryID">
                        <div class="box_form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NAME</label>
                                        <input type="text" id="categoryName" name="categoryName" class="form-control"
                                               placeholder="Category Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Order</label>
                                        <input type="number" id="categoryOrder" name="categoryOrder"
                                               class="form-control"
                                               placeholder="Order in the list">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>FrontPage</label>
                                        <select class="form-control" id="categoryFront" name="frontPage">
                                            <option value="1">YES</option>
                                            <option value="0" selected>NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary btnUpdateOrder" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{/block}

{block name="footer" append}
    <script>
        $(function () {
            $('.frontPage').each(function () {
                let val = $(this).html() == "1" ? "YES" : "NO";
                $(this).html(val);
            });

            $('.btnDelete').on('click', function () {
                let categoryID = $(this).data("category");
                {literal}
                let categoryData = {categoryID: categoryID}
                {/literal}
                if (confirm("Are you sure you want to delete the category " + categoryID + "?"))
                    AjaxPost('{$siteurl}adminDeleteCategory', categoryData, function (data) {
                        if (data['state'] == "success") {
                            $("#category" + categoryID).remove();
                            alert(data['message']);
                        }
                        else
                            alert(data['message'])
                    });
            });

            $('.btnEdit').on('click', function () {
                let categoryID = $(this).data('category');
                let categoryName = $(this).data('name');
                let categoryOrder = $(this).data('order');
                let categoryFront = $(this).data('front');

                $('#categoryID').val(categoryID);
                $('#categoryName').val(categoryName);
                $('#categoryOrder').val(categoryOrder);
                $('#modalEDIT').modal();
            });

            $('.ajaxForm').bind('success', function (e, id) {
                let name = $('#frmcategoryName').val();
                let order = $('#frmcategoryOrder').val();
                let front = $('#categoryfrontPage').find(':selected').text();

                $('#dataTable').append(' <tr>\n' +
                    '                                    <td>' + id + '</td>\n' +
                    '                                    <td>' + name + '</td>\n' +
                    '                                    <td>' + order + '</td>\n' +
                    '                                    <td class="frontPage">' + front + '</td>\n' +
                    '                                    <td>\n' +
                    '                                        <button class="btn btn-success btnEdit" data-category="' + id + '"\n' +
                    '                                                data-name="' + name + '" data-order="' + order + '"\n' +
                    '                                                data-frontpage="' + front + '">EDIT\n' +
                    '                                        </button>\n' +
                    '                                        <button class="btn btn-danger btnDelete" data-category="' + id + '">DELETE\n' +
                    '                                        </button>\n' +
                    '                                    </td>\n' +
                    '                                </tr>')
            });
        });
    </script>
{/block}