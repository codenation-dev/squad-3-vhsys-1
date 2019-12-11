    <footer class="page-footer grey darken-2">
        <div class="container center">
            <div class="">
                <h5 class="white-text footer-text" >AceleraDev PHP Codenation - Squad 3</h5>
                <p style="padding-bottom:20px">© {{ date('Y') }} Copyright </p>
            </div>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            M.updateTextFields();
            $('.sidenav').sidenav();
        });

        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems, options);
        });

        $(document).ready(function(){
            $('select').formSelect();
            $('.modal').modal();
        });
    </script>
</body>

</html>