# Todo List
* [ ] [searchbox.php] set search form action language (`/en`) based on the project lang:
  `action="https://www.deepi.ir/en/dashboard/search/"`
* [ ] [functions.php] change default lang to english: `. substr(get_bloginfo( 'language' ), 0, 2)`
  `$link = "https://www.deepi.ir/". substr(get_bloginfo( 'language' ), 0, 2) ."/".deepi_fetch_key('slug')."/cached/?path=".$post->guid;`
