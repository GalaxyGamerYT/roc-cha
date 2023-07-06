<?php

    function curlIt($resource, $urlParams, $options = []) {
        $url = "https://musicbrainz.org/ws/2/{$resource}/?" . http_build_query(array_map('urlencode', $urlParams));
    
        $handle = curl_init($url);
        $default = [
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:109.0) Gecko/20100101 Firefox/116.0',
            CURLOPT_RETURNTRANSFER => true,
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
        return curlIt('artist', [
            'fmt' => 'json',
            'query' => $search,
            'limit' => 1,
        ]);
    }
    
    function getAlbum($artistId, $album) {
        return curlIt('release', [
            'fmt' => 'json',
            'query' => $album . ' AND arid:' . $artistId,
            'limit' => 1,
        ]);
    }
    
    
    header('Content-type: application/json');
    // header('Content-type: text/plain');
    var_dump(getAlbum(getArtist("Alan Walker")['artists'][0]['id'],"Different World"));
?> 