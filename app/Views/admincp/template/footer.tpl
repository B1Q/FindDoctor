{* SMARTY *}


<footer class="sticky-footer">
    <div class="container">
        <div class="text-center">
            <small>© {'Y'|date} {$name}</small>
        </div>
    </div>
</footer>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
</a>
<!-- Logout Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="/logout">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="{$assetsPath}/adminassets/vendor/jquery/jquery.min.js"></script>
<script src="{$assetsPath}/adminassets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="{$assetsPath}/adminassets/vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Page level plugin JavaScript-->
<script src="{$assetsPath}/adminassets/vendor/datatables/jquery.dataTables.js"></script>
<script src="{$assetsPath}/adminassets/vendor/datatables/dataTables.bootstrap4.js"></script>
<script src="{$assetsPath}/adminassets/vendor/jquery.selectbox-0.2.js"></script>
<script src="{$assetsPath}/adminassets/vendor/retina-replace.min.js"></script>
<script src="{$assetsPath}/adminassets/vendor/jquery.magnific-popup.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="{$assetsPath}/adminassets/js/admin.js"></script>
<script src="{$assetsPath}/js/ckeditor/ckeditor.js"></script>
<script src="{$jsPath}custom.js"></script>


{include file= "template/jqueryScripts.tpl"}