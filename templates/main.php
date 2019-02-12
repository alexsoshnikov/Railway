<div id="chooseRoute">Choose your route</div>
<div class="form">
    <input class="text" type="text" placeholder="From">
    <input class="text" type="text" placeholder="To">
    <div class="datapicker">
        <input id="datepicker" placeholder="Date" width="200px" />
        <script>
            $('#datepicker').datepicker({
                uiLibrary: 'bootstrap'
            });
        </script>
    </div>
</div>
<div class="searchButton">
    <input class="submit" type="submit" value="Search"> </div>