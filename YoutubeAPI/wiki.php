<?php
include ('index2.php');


//wiki
function wikipedia_search ($searchQuery, $limit) {
    return json_decode(file_get_contents('https://en.wikipedia.org/w/api.php?action=query&list=search&prop=info&inprop=url&utf8&format=json&origin=*&srlimit='.$limit.'&srsearch='.$searchQuery), true);
}

if (isset($_GET['query'])) {
    
    $wikipedia_search = wikipedia_search(str_replace(' ', '+', $_GET['query']), 20);
    $search_list = $wikipedia_search['query']['search'];
    
    //print '<pre>';   
    //print_r ($search_list);
    //print '</pre>';
}


?>

<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script>

    function translateWiki (from, to, pageId, wikiTitle, wikiDescription) {
        
        // retrieve video title and description by videoId
        // send request to tranlate.php with different values and get translation as text
        // replace content of video tilte and description with the returned translation
        
        // $.get(url:string, callback:function);
        if (to != '') {
            // Retrieve video title and translate it
            //var videoTitle = $('#video-' + videoId + '-title').text();
            $.get ('translate.php?from=' + from + '&to=' + to + '&text=' + wikiTitle, function (response) {
                $('#wiki-' + pageId + '-title').html(response);
            });

            // Retrieve video description and translate it
            //var videoDescription = $('#video-' + videoId + '-description').text();

            $.get ('translate.php?from=' + from + '&to=' + to + '&text=' + wikiDescription, function (response) {
                $('#wiki-' + pageId + '-description').html(response);
            });
        }
    }

</script>


<div class="row mt-5">
        
        <?php foreach ($search_list as $item) : ?>
        <div class="col-md-4 text-left mb-5">
            <a href="https://en.wikipedia.org/?curid=<?php print $item['pageid']; ?>" target="_blank">
                <div class="media">
                    <div class="media-body">
                        <h2 class="mt-0" id="wiki-<?php print $item['pageid']; ?>-title"><?php print $item['title']; ?></h2>
                        <h3 class="mt-0" id="wiki-<?php print $item['pageid']; ?>-description"><?php print $item['snippet']; ?></h3>

                    </div>
                </div>
            </a>
           <select onchange="translateWiki('en', this.value, '<?php print $item['pageid']; ?>', '<?php print str_replace("'", "\'", strip_tags($item['title'])); ?>', '<?php print str_replace("'", "\'", strip_tags($item['snippet'])); ?>');">
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