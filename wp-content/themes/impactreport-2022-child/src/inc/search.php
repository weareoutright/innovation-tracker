<?php

trait ThemeSearch {
  /**
   * filter: query_vars
   * add query parameters for access later in the Theme app
   * @param $qvars
   * @return mixed
   * @see https://developer.wordpress.org/reference/hooks/query_vars/
   */
  // function theme_query_vars($qvars) {
  //   // add variables to be able to query on meta fields
  //   $qvars[] = 'strategies';
  //   $qvars[] = 'issues';
  //   $qvars[] = 'locations';
  //   $qvars[] = 'start_date';
  //   $qvars[] = 'type';
  //   // Do a search-like query without using the ?s= query string, which can cause conflicts
  //   $qvars[] = 'keyword';
  //   return $qvars;
  // }
}

?>