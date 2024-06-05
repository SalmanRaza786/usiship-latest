<footer class="footer">
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © {{isset($appInfo[0])?$appInfo->where('key','app_title')->pluck('value')->first():'BDC'}}
            </div>

        </div>
    </div>
</footer>
