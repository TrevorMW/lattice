<?php $html = '';

if( is_array($team) ){

    foreach( $team['members'] as $member ){
        $html .= Team_Member::getTeamMemberGridItem($member, true);
    }
}

return $html;