
 <?php

   add_shortcode('seasons-table', 'render_seasons');
    function render_seasons() {

        $api_seasons = torneopal_getSeasons();
        $api_categories = torneopal_getCategories();
        $groupResults = torneopal_getGroup();
        if(isset($_GET["homeaway"])){
            $homeaway=$_GET["homeaway"];
        } else { $homeaway='all';}
        $homeawayArray=array('all' => 'Kaikki', 'home' => 'Kotipelit', 'away' => 'Vieraspelit');  
        ob_start();
        ?>
        <div class="web-content-wrapper">
        <div class="web-content web-content-page">
        <div class="web-content-page-content statistics">
        <h1>Joukkuetilastot</h1>
        <div class="filters">
        <dl>
            <dt><span>Kausi</span></dt>
            <dd>
                <form>
                <select id="selectSeasons" name="season" onchange="this.form.submit()">
                    <?php if(isset($api_seasons)) {
                            if(isset($_GET["season"])){
                                $activeSeason=$_GET["season"];
                            } else { $activeSeason='2019'; }
                        foreach( $api_seasons->seasons as $season ) {
                            if ($season->season_id == $activeSeason) {
                                echo '<option value="'. $season->season_id .'" selected><text>'. $season->season_id .'</text></option>';
                            } 
                            else {
                                echo '<option value="'. $season->season_id .'"><text>'. $season->season_id .'</text></option>';
                            }
                        }
                    }
                    else
                    {
                        echo '<option>Kausia ei löytynyt</option>'; 
                    } ?>
                </select>
            </dd>
        </dl>

        <dl>
            <dt><span>Sarja</span></dt>
            <dd>
                <select id="selectLeague" name="league" onchange="this.form.submit()">
                    <?php if(isset($api_categories)) {
                            if(isset($_GET["league"])){
                                $activeLeague=$_GET["league"];
                            }
                        foreach( $api_categories->categories as $category ) {
                            if ($category->category_id == $activeLeague) {
                                echo '<option value="'. $category->category_id .'" selected><text>'. $category->category_name .'</text></option>';
                            } else {
                                echo '<option value="'. $category->category_id .'"><text>'. $category->category_name .'</text></option>';
                            }
                        }
                    }
                    else
                    {
                        echo '<option>Sarjoja ei löytynyt</option>'; 
                    } ?>
                </select>

            </dd>
            </dl>

            <dl>
                <dt><span>Koti/vierasottelut</span></dt>
                <dd>
                    <select id="selectHomeAway" name="homeaway" onchange="this.form.submit()">
                    <?php 
                        foreach( $homeawayArray as $value => $homeawayItem ) {
                            if ($value == $homeaway) {
                                echo '<option value="'. $value .'" selected><text>'. $homeawayItem .'</text></option>';
                            } else {
                                echo '<option value="'. $value .'"><text>'. $homeawayItem .'</text></option>';
                            }
                        } ?>
                    </select>
                    </form>
                </dd>
            </dl>
            </div>
            <div style="clear: both;"></div>

            <!-- Table start -->
            <table id="statistics_i" class="tablesorter">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> </th>
                                    <th class="team">Joukkue</th>
                                    <th title="Ottelut">O</th>
                                    <th title="Voitot">V</th>
                                    <th title="Tasapelit">T</th>
                                    <th title="Häviöt">H</th>
                                    <th title="Tehdyt maalit">TM</th>
                                    <th title="Päästetyt maalit">PM</th>
                                    <th title="Maaliero">ME</th>
                                    <?php if ($homeaway == "all")
                                    { ?>
                                        <th title="Maalisyötöt">S</th>
                                        <th title="Laukaukset">L</th>
                                        <th title="Maaliprosentti">L%</th>
                                        <th title="Rikkeet yhteensä">R</th>
                                        <th title="Varoitukset">KK</th>
                                        <th title="Ulosajot">PK</th>
                                    <?php } ?>
                                    <th title="Pisteet">P</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- @{
                                    int _ii = 1;
                                    foreach (sjk2007shop.Models.TasoAPI.GroupTeam _gt in _group.GroupTeams_LiveStandings)
                                    { -->
                                    <?php 
                                        // foreach ($groupResults->player_statistics as $playerStatistic) { 
                                        //     if ($playerStatistic->team_id == '60970') {
                                        //         ($playerStatistic->player_name);
                                        //     }

                                        //     return array_filter($groupResults->player_statistics, function($var)
                                        //         {
                                        //         return($var->team_id == $currentTeamId);
                                        //         });
                                        //  }

                                        $i = 0;
                                        foreach ($groupResults->teams as $team) { $i++; ?>
                                        <tr>
                                        <?php if ($homeaway == "home")
                                            { ?>
                                                <td><?php print_r($i) ?></td>
                                                <td class='crest'><img  src="<?php print_r($team->crest) ?>"></td>
                                                <td class="team"><?php print_r($team->team_name) ?></td>
                                                <td><?php print_r($team->matches_played_home) ?></td>
                                                <td><?php print_r($team->matches_won_home) ?></td>
                                                <td><?php print_r($team->matches_tied_home) ?></td>
                                                <td><?php print_r($team->matches_lost_home) ?></td>
                                                <td><?php print_r($team->goals_for_home) ?></td>
                                                <td><?php print_r($team->goals_against_home) ?></td>
                                                <td><?php print_r($team->goals_for_home - $team->goals_against_home) ?></td>
                                                <td><?php print_r($team->points_home) ?></td> 
                                        <?php } elseif ($homeaway == "away")
                                                { ?>
                                                <td><?php print_r($i) ?></td>
                                                <td class='crest'><img  src="<?php print_r($team->crest) ?>"></td>
                                                <td class="team"><?php print_r($team->team_name) ?></td>
                                                <td><?php print_r($team->matches_played_away) ?></td>
                                                <td><?php print_r($team->matches_won_away) ?></td>
                                                <td><?php print_r($team->matches_tied_away) ?></td>
                                                <td><?php print_r($team->matches_lost_away) ?></td>
                                                <td><?php print_r($team->goals_for_away) ?></td>
                                                <td><?php print_r($team->goals_against_away) ?></td>
                                                <td><?php print_r($team->goals_for_away - $team->goals_against_away) ?></td>
                                                <td><?php print_r($team->points_away) ?></td> 
                                           <?php }
                                            else
                                            { 
                                                 
                                                $playerStatistics=array();
                                                $playerAssists=array();
                                                $playerShotsTotal=array();
                                                $playerFouls=array();
                                                $playerWarnings=array(); 
                                                $playerSuspensions=array(); 
                                                $playerShootPercentage= ''; 
                                                foreach ($groupResults->player_statistics as $playerStatistic) {
                                                    if ($playerStatistic->team_id == $team->team_id) {
                                                    array_push($playerStatistics, $playerStatistic);
                                                    array_push($playerAssists, $playerStatistic->assists);
                                                    array_push($playerShotsTotal, $playerStatistic->shots_total);
                                                    array_push($playerFouls, $playerStatistic->fouls);
                                                    array_push($playerWarnings, $playerStatistic->warnings);
                                                    array_push($playerSuspensions, $playerStatistic->suspensions);
                                                    }
                                                }
                                                if ($team->goals_for == 0) {
                                                    $playerShootPercentage = 0;
                                                } else {
                                                    $playerShootPercentage = 100 / array_sum($playerShotsTotal) * $team->goals_for;
                                                }
                                                // print_r($playerStatistics[0]);
                                                ?>
                                                <td><?php print_r($i) ?></td>
                                                <td class='crest'><img  src="<?php print_r($team->crest) ?>"></td>
                                                <td class="team"><?php print_r($team->team_name) ?></td>
                                                <td><?php print_r($team->matches_played) ?></td>
                                                <td><?php print_r($team->matches_won) ?></td>
                                                <td><?php print_r($team->matches_tied) ?></td>
                                                <td><?php print_r($team->matches_lost) ?></td>
                                                <td><?php print_r($team->goals_for) ?></td>
                                                <td><?php print_r($team->goals_against) ?></td>
                                                <td><?php print_r($team->goals_for - $team->goals_against) ?></td>
                                                <td><?php print_r(array_sum($playerAssists)) ?></td>
                                                <td><?php print_r(array_sum($playerShotsTotal)) ?></td>
                                                <td><?php print_r(sprintf('%02.2f', $playerShootPercentage).'%') ?></td>
                                                <td><?php print_r(array_sum($playerFouls)) ?></td>
                                                <td><?php print_r(array_sum($playerWarnings)) ?></td>
                                                <td><?php print_r(array_sum($playerSuspensions)) ?></td>
                                                <td><?php print_r($team->points) ?></td>
                                           <?php }
                                       echo '</tr>';
                                    }
                                  ?>
                            </tbody>
                        </table>
            <!-- Table End -->
            <div class="statistics-prefix-list">
                        <h4>Lyhenteet</h4>
                        <dl>
                            <dt>O</dt>
                            <dd>Ottelut</dd>
                            <dt>P</dt>
                            <dd>Pisteet</dd>
                        </dl>

                        <dl>
                            <dt>V</dt>
                            <dd>Voitot</dd>
                            <dt>T</dt>
                            <dd>Tasapelit</dd>
                            <dt>H</dt>
                            <dd>Häviöt</dd>
                        </dl>

                        <dl>
                            <dt>TM</dt>
                            <dd>Tehdyt maalit</dd>
                            <dt>PM</dt>
                            <dd>Päästetyt maalit</dd>
                            <dt>ME</dt>
                            <dd>Maaliero</dd>
                        </dl>

                        <?php if ($homeaway == "all")
                        { ?>
                            <dl>
                                <dt>S</dt>
                                <dd>Maalisyötöt</dd>
                                <dt>L</dt>
                                <dd>Laukaukset</dd>
                                <dt>L%</dt>
                                <dd>Maaliprosentti</dd>
                            </dl>

                            <dl>
                                <dt>R</dt>
                                <dd>Rikkeet yhteensä</dd>
                                <dt>KK</dt>
                                <dd>Varoitukset</dd>
                                <dt>PK</dt>
                                <dd>Ulosajot</dd>
                            </dl>
                            <?php } ?>
                    </div>
            </div>            
        </div>
    </div>
        <?php
	return ob_get_clean();

    }


    function torneopal_getSeasons() {
            $request = wp_remote_get( 'https://spl.torneopal.fi/taso/rest/getSeasons?api_key=<API_KEY>&club_id=3307');
            if( is_wp_error( $request ) ) {
                return false; // Bail early
            }
            $body = wp_remote_retrieve_body( $request );
            return json_decode( $body );
        }

    function torneopal_getCategories() {
        $request = wp_remote_get( 'https://spl.torneopal.fi/taso/rest/getCategories?api_key=<API_KEY>&category_id=VL&authorized_only=1');
        if( is_wp_error( $request ) ) {
            return false; // Bail early
        }
        $body = wp_remote_retrieve_body( $request );
        return json_decode( $body );
    }

    function torneopal_getGroup() {

        if(isset($_GET["season"])){
            $season=$_GET["season"];
        } else { $season='2019';}

        // getCompetitions
        $request = wp_remote_get( 'https://spl.torneopal.fi/taso/rest/getCompetitions?api_key=<API_KEY>');
        if( is_wp_error( $request ) ) {
            return false; // Bail early
        }
        $competitions = json_decode(wp_remote_retrieve_body( $request ));
        foreach( $competitions->competitions as $competition ) {
            if ($competition->season_id == $season) {
                $currentSeason = $competition->competition_id;
            }
        }
        

        if(isset($currentSeason)) {
            $newRequest = wp_remote_get( 'https://spl.torneopal.fi/taso/rest/getGroup?api_key=<API_KEY>&competition_id=' . $currentSeason .'&category_id=VL&group_id=1');
            if( is_wp_error( $newRequest ) ) {
                return false; // Bail early
            }
            $groups = json_decode(wp_remote_retrieve_body( $newRequest ));
            return  $groups->group;
            
            }


    }

    ?>