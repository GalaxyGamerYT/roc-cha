<?php
    function curlIt($resource, $urlParams, $options = [], $id = true) {
        if ($id) {
            $url = "https://musicbrainz.org/ws/2/{$resource}/?" . http_build_query($urlParams,"",null,PHP_QUERY_RFC3986);
        } else {
            $url = "http://coverartarchive.org/{$resource}/{$urlParams['id']}";
        }

        $handle = curl_init($url);
        $default = [
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:109.0) Gecko/20100101 Firefox/116.0',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
        ];
    
        foreach ($options as $key => $value) {
            $default[$key] = $value;
        }
    
        curl_setopt_array($handle, $default);
        $result = curl_exec($handle);
        curl_close($handle);
        return $result ? json_decode($result,true) : false;
    }
    
    function getArtist($search) {
        return (curlIt('artist', [
            'fmt' => 'json',
            'query' => $search,
            'limit' => 1,
        ]))['artists'][0]['id'];
    }
    
    function getAlbum($artistId, $album) {
        return (curlIt('release', [
            'fmt' => 'json',
            'query' => $album . ' AND arid:' . $artistId,
            'limit' => 1,
        ]))['releases'][0]['id'];
    }
    
    function getArt($albumId) {
        return append_filename((curlIt('release',[
            'id' => $albumId,
        ],[CURLOPT_FOLLOWLOCATION => true],false))['images'][0]['image'],"1200");
    }

    function append_filename($file, $append) {
        preg_match("#^(.*)\.(.+?)$#", $file, $matches);
        return $matches[1]."-".$append.'.'.$matches[2];
    }
?>