<div class="whiteBox_main">
    <div class="header_whiteBox">Choose your route</div>
    <form id="form_search" action="index.php" method="POST">
        <div class="form">
            <input class="text" id="cityFrom" type="text" placeholder="From">
            <input class="text" id="cityTo" type="text" placeholder="To">
            <div class="datapicker">
                <input id="datepicker" type="text" placeholder="Date" width="200px" />
                <script>
                    $('#datepicker').datepicker({
                        uiLibrary: 'bootstrap'
                    });
                </script>
            </div>
        </div>
        <div class="searchButton">
            <input class="submit" type="submit" value="Search"> </div>
    </form>
    <div class="loadingCities">
        <div class="load-1">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </div>
</div>