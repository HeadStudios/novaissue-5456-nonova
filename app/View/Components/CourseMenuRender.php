<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class CourseMenuRender extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $menuItems;
     protected $isAdmin;
     protected $isSuperman;

    


    public function __construct()
    {

        
        if (Auth::check()) {
            $user = Auth::user();
            $this->isAdmin = $user->isRole('admin');
            $this->isSuperman = $user->isRole('superadmin');
        }


        
        $request = app('request');
        $slug = $request->segment(2);
        


        $mymenu = ['Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5'];

        $trainee_menu = array(

            array('name' => 'Dashboard',
            'svg' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z',
            'permalink' => 'dashboard'),

            array('name' => 'Tasks',
            'permalink' => 'tasks',
            'svg' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'),

            array('name' => 'Courses',
            'permalink' => 'courses',
            'svg' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'),

            

        );

        $admin_menu = array(

            array('name' => 'Team',
            'permalink' => 'team',
            'svg' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'),

            

        );

        $sadmin_menu = array(

            array('name' => 'Approvals',
            'permalink' => 'approval',
            'svg' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'),

        );

        if($this->isAdmin) {

            foreach($admin_menu as $item) {
                array_push($trainee_menu, $item);
            }
            
            //array_unshift($trainee_menu, $admin_menu);
        }

        if($this->isSuperman) {

            foreach($sadmin_menu as $item) {
                array_push($trainee_menu, $item);
            }
            
            //array_unshift($trainee_menu, $admin_menu);
        }

        


        $perma_base = basename(url()->current());

        foreach ($trainee_menu as &$item) {
            if (isset($item['permalink']) && $item['permalink'] == $perma_base) {
                $item['status'] = true;
            }
        }

        

        $this->menuItems = $trainee_menu;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        //$request = new Request();
        
        return view('components.course-menu-render', ['title' => 'We can fly all the time', 'menu' => $this->menuItems]);
    }
}
