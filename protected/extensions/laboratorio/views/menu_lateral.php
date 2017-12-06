<?php $base_url = Yii::app()->request->baseUrl.'/'; ?>
<aside>
    <div id="sidebar"  class="nav-collapse ">
         <ul class="sidebar-menu" id="nav-accordion">
             <?php foreach ($items as $item) :
                 $item_url = $base_url.$item['url'];
                 $target = '';
                 if (isset($item['external_link']) && $item['external_link']) {
                     $item_url = $item['url'];
                     $target = 'target="_blank" ';
                 }
                 $url   = (isset($item['items'])) ? 'javascript:;' : $item_url;
                 $icon  = (isset($item['icon'])) ? '<i class="icon-'.$item['icon'].'"></i>' : '';
                 $label = (isset($item['label'])) ? '<span>'.$item['label'].'</span>' : '';
                 $submenu_class = (isset($item['items'])) ? 'class="sub-menu"' : '';
                 $active_class = (isset($item['cod']) && $item['cod'] == $active['menu']) ? 'class="active"' : '';

                 $submenus = '';
                 if (isset($item['items'])) {
                     $submenus = '<ul class="sub">';
                     foreach ($item['items'] as $subitem) :
                        $sub_url   = (isset($subitem['items'])) ? 'javascript:;' : $base_url.$subitem['url'];
                        $sub_icon  = (isset($subitem['icon'])) ? '<i class="icon-'.$subitem['icon'].'"></i>' : '';
                        $sub_label = (isset($subitem['label'])) ? '<span>'.$subitem['label'].'</span>' : '';
                        $sub_active_class = (isset($subitem['cod']) && $subitem['cod'] == $active['submenu']) ? 'class="active"' : '';
                        $submenus .= '
                        <li '.$sub_active_class.'>
                            <a href="'.$sub_url.'">
                                 '.$sub_icon.'
                                 '.$sub_label.'
                             </a>
                        </li>';
                        
                     endforeach;
                     $submenus .= '</ul>';
                 }
                 
                 echo '
                    <li '.$submenu_class.'>
                        <a '.$target.$active_class.' href="'.$url.'">
                             '.$icon.'
                             '.$label.'
                         </a>
                         '.$submenus.'
                    </li>';
             endforeach; ?>
         </ul>
    </div>
</aside>