<?php namespace App\Libraries;

class React extends DataTemplate
{
    public function getTemplate(): array {
        $layout_model = new \App\Modules\Layouts\Models\LayoutModel();

        $module = get_module();
        $template = [];
        
        $position_list = [
            'header_top',
            'header_bottom',
            'column_left',
            'column_right',
            'content_top',
            'content_bottom',
            'footer_top',
            'footer_bottom',
        ];

        foreach ($position_list as $value) {
            $layout_list = $layout_model->getLayoutsByPostion($module, $value);
            if (empty($layout_list)) {
                continue;
            }

            foreach ($layout_list as $layout) {
                $action = explode("|", $layout['action']);
                if (count($action) != 2) {
                    continue;
                }

                $data_name = "data" . ucfirst($action[0]);
                $template[$value][] = [
                    'key' => str_replace("/", "_", $action[1]),
                    'subreddit' => $action[1],
                    'data' => $this->{$data_name}()
                ];
            }
        }

        return $template;
    }

    
}
