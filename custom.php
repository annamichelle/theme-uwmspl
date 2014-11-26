<?php 

function cls_exhibit_navigation ($exhibitPage = null) 
{
    if (!$exhibitPage) {
        $exhibitPage = get_current_record('exhibit_page');
    }

    $exhibit = $exhibitPage->getExhibit();
    $pages = $exhibit->getTopPages();
    $html = '';

    $parents = array();
    $pageLoop = $exhibitPage;
    while ($pageLoop->parent_id) {
        $parents[] = $pageLoop->parent_id;
        $pageLoop = $pageLoop->getParent();
    }
    
    $html .= '<ul class="exhibit-page-nav navigation" id="secondary-nav">' . "\n";

    foreach ($pages as $page) {
        $current = (exhibit_builder_is_current_page($page)) ? ' class="current"' : '';
        $pageId = $page->id;
        $children = $page->getChildPages();
        $html .= '<li' . $current . '>' . exhibit_builder_link_to_exhibit($exhibit, $page->title, array(), $page);
        if (($current && $children) || in_array($pageId, $parents)) {
            $html .= '<ul id="child-pages">';
            foreach ($children as $child) {
                $current = (exhibit_builder_is_current_page($child)) ? ' class="current"' : '';
                $childId = $child->id;
                $grandchildren = $child->getChildPages();
                $html .= '<li' . $current . '>' . exhibit_builder_link_to_exhibit($exhibit, $child->title, array(), $child);
                if (($current && $grandchildren) || in_array($childId, $parents)) {
                    $html .= '<ul id="grandchild-pages">';
                    foreach ($grandchildren as $grandchild) {
                        $current = (exhibit_builder_is_current_page($grandchild)) ? 'class="current"' : '';
                        $html .= "<li $current>" . exhibit_builder_link_to_exhibit($exhibit, $grandchild->title, array(), $grandchild) . '</li>' . "\n";
                    }
                    $html .= '</ul>' . "\n";
                }
                $html .= '</li>' . "\n";
            }
            $html .= '</ul>' . "\n";
        }
        $html .= '</li>' . "\n";
    }

    $html .= '</ul>' . "\n";
    return $html;
}

/**
 * Return a link to the first top-level page for this exhibit
 *
 * @param ExhibitPage $exhibitPage
 * @param string $text Link text
 * @return string
*/
function cls_exhibit_link_to_first_page($exhibit = null, $text = null)
{
    if(!$exhibit) {
        $exhibit = get_current_record('exhibit');
    }

    $pages = $exhibit->getTopPages();

    $firstPage = $pages[0];

    if (!$text) {
        $text = 'Continue to Exhibit &#8594;';
    }

    return exhibit_builder_link_to_exhibit($exhibit, $text, array(), $firstPage);
}

function emiglio_exhibit_builder_page_summary($exhibitPage = null)
{
    if(!$exhibitPage) {
        $exhibitPage = get_current_record('exhibit_page');
    }

    $html = '<li>'
            . '<a href="' . exhibit_builder_exhibit_uri(get_current_record('exhibit'), $exhibitPage) . '">'
            . metadata($exhibitPage, 'title') . '</a>'
            . '</li>';
    return $html;
}

function return_to_exhibit(){
    $back = htmlspecialchars($_SERVER['HTTP_REFERER']);
    $html = '<a href="' . $back . '">&larr; Back to the Exhibit</a>';
    return $html;
}

function emiglio_exhibit_builder_summary_accordion($exhibitPage = null)
{
    if (!$exhibitPage) {
        $exhibitPage = get_current_record('exhibit_page');
    }

    $html = '<h3>' . metadata($exhibitPage, 'title') .'</h3>';

    $children = $exhibitPage->getChildPages();
    if ($children) {
        $html .= '<div><a href="' . exhibit_builder_exhibit_uri(get_current_record('exhibit'), $exhibitPage) 
                . '">' . metadata($exhibitPage, 'title') .'</a><ul>';
        foreach ($children as $child) {
            $html .= exhibit_builder_page_summary($child);
            release_object($child);
        }
        $html .= '</ul></div>';
    }
    else {
        $html .= '<div><a href="' . exhibit_builder_exhibit_uri(get_current_record('exhibit'), $exhibitPage) 
                . '">' . metadata($exhibitPage, 'title') .'</a></div>';
    }
    return $html;
}
?>
