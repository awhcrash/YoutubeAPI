<?php

include ('index2.php');

function youtube_search ($searchQuery, $maxResults) {
    $apiKey = 'AIzaSyB4_pC_kJ5_v2FhetWSv1y-ZzhmIfC6sEw';
    return json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?q='.$searchQuery.'&key='.$apiKey.'&part=snippet&&maxResults='.$maxResults), true);
}

if (isset($_GET['query'])) {
    
    $videos_search = youtube_search(str_replace(' ', '+', $_GET['query']), 5);
    $search_list = $videos_search['items'];
    
    //print '<pre>';   
    //print_r ($search_list);
    //print '</pre>';
}

//Wiki

?>


<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script>

    function translateVideo (from, to, videoId, videoTitle, videoDescription) {
        
        // retrieve video title and description by videoId
        // send request to tranlate.php with different values and get translation as text
        // replace content of video tilte and description with the returned translation
        
        // $.get(url:string, callback:function);
        if (to != '') {
            // Retrieve video title and translate it
            //var videoTitle = $('#video-' + videoId + '-title').text();
            $.get ('translate.php?from=' + from + '&to=' + to + '&text=' + videoTitle, function (response) {
                $('#video-' + videoId + '-title').html(response);
            });

            // Retrieve video description and translate it
            //var videoDescription = $('#video-' + videoId + '-description').text();

            $.get ('translate.php?from=' + from + '&to=' + to + '&text=' + videoDescription, function (response) {
                $('#video-' + videoId + '-description').html(response);
            });
        }
    }

</script>

<div class="container text-center">

    <h3>Recommended <?php print $_GET['query']; ?> Videos From Youtube</h3>
    
    <br>
    
    <div class="row mt-5">
        
        <?php foreach ($search_list as $item) : ?>
        <div class="col-md-4 text-left mb-5">
            <a href="https://www.youtube.com/watch?v=<?php print $item['id']['videoId']; ?>" target="_blank">
                <div class="media">
                    <img src="<?php print $item['snippet']['thumbnails']['default']['url']; ?>" class="mr-3" alt="...">
                    <div class="media-body">
                        <h3 class="mt-0" id="video-<?php print $item['id']['videoId']; ?>-title"><?php print $item['snippet']['title']; ?></h3>
                        <h4 class="mt-0" id="video-<?php print $item['id']['videoId']; ?>-description"><?php print $item['snippet']['description']; ?></h4>

                    </div>
                </div>
            </a>
            <select onchange="translateVideo('en', this.value, '<?php print $item['id']['videoId']; ?>', '<?php print $item['snippet']['title']; ?>', '<?php print $item['snippet']['description']; ?>');">
                <option value="">Translate</option>
                <option value="ar">Translate To Arabic</option>
                <option value="sv">Translate To Swedish</option>
                <option value="fr">Translate To French</option>
                <option value="de">Translate To Deutch</option>
            </select>
            <br><br>
        </div>
        <?php endforeach; ?>
        
    </div>
    
</div>