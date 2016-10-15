<?php

namespace App\Http\Controllers;

use App\Models\NavItems;
use App\Models\NewsItems;
use App\Models\Quote;
use Auth;

trait ControllerUtils
{

    private function _getEventData($path = null)
    {
        if (isset($path)) {
            $ventourist = $path == 'ventourist';
            $lacannibalette = $path == 'lacannibalette';
            $lacannibale = $path == 'lacannibale';
            $tomsimpson = $path == 'tomsimpsonmemorial';
        } else {
            $ventourist = false;
            $lacannibalette = false;
            $lacannibale = false;
            $tomsimpson = false;
        }
        $event = [];
        $event['title'] = '&Eacute;&eacute;n mythische col - Vier hero&iuml;sche uitdagingen';
        $event['subtitle'] = 'Waarom zo snel mogelijk inschrijven?';
        $event['subtitle_url'] = url('p/snel-inschrijven');
        $event['challenges'] = [];
        $event['challenges'][] = [
            'title' => 'Ventourist',
            'color' => 'purple',
            'distance' => '1 col - 1912m - 21, 22 of 26 km',
            'url' => url('programma/ventourist'),
            'class' => ($ventourist ? 'active' : '')
        ];
        $event['challenges'][] = [
            'title' => 'Memorial Tom Simpson',
            'color' => 'gold',
            'distance' => '1 col - 21km - eerbetoon aan Tom Simpson',
            'url' => url('programma/tomsimpsonmemorial'),
            'class' => $tomsimpson ? 'active' : ''
        ];
        $event['challenges'][] = [
            'title' => 'la Cannibalette',
            'color' => 'red',
            'distance' => '4 cols - 131km - 3525 hoogtemeters',
            'url' => url('programma/lacannibalette'),
            'class' => $lacannibalette ? 'active' : ''
        ];
        $event['challenges'][] = [
            'title' => 'la Cannibale',
            'color' => 'red',
            'distance' => '6 cols - 173km - 4529 hoogtemeters',
            'url' => url('programma/lacannibale'),
            'class' => $lacannibale ? 'active' : ''
        ];
        return $event;
    }

    private function _getEventDayData()
    {
        $data = [];
        $data['title'] = '';
        $data['subtitle'] = '';
        $data['subtitle_url'] = url('p/snel-inschrijven');
        $data['buttons'] = [];
        $data['buttons'][] = [
            'title' => 'Bekijk de foto\'s',
            'color' => 'red',
            'url' => url('https://www.facebook.com/monventoux.be/photos'),
//            'url' => url('eventfotos'),
            'class' => ''
        ];
        /*
        $data['buttons'][] = [
            'title' => 'Livestream Top',
            'color' => 'red',
            'url' => url('livestream/top'),
            'class' => ''
        ];
        /*
        $data['buttons'][] = [
            'title' => 'Livestream Village Cannibale',
            'color' => 'red',
            'url' => url('livestream/village'),
            'class' => ''
        ];
        */

        return $data;
    }

    private function _getColor($program)
    {
        switch ($program) {
            case 'ventourist':
                return 'purple';
                break;
            case 'lacannibalette':
                return 'red';
                break;
            case 'lacannibale':
                return 'red';
                break;
            default:
                return 'gold';
                break;
        }

    }

    /**
     * Count days untill start date.
     * @return int of days
     */
    private function _getDaysUntilStart()
    {
        // get today date and time
        $now = new \DateTime();
        $now->format('Y-m-d');
        $today = $now->getTimestamp();

        // event date.
        // @TODO: make sure this is a date string from database
        $mysqldate = '2017-06-17 00:00:00';
        $eventdate = new \DateTime($mysqldate);
        $eventdate->format('Y-m-d');
        $eventday = $eventdate->getTimestamp();

        // test.. maybe we need to use 'round' instead of 'ceil'
        return ceil(($eventday / 86400) - ($today / 86400));

    }


    private function _getNewsData(){
        //get max 10 newsitems that have start value in the past and have no end or are not ended yet (end in the past) and order by latest item first (for homepage partial-news)
        $news = NewsItems::
            where('start', '<', date('Y-m-d H:i:s'))
            ->where(function($query) {
                $query->where('end', '=', '0000-00-00 00:00:00')
                    ->orWhere('end', '>', date('Y-m-d H:i:s'));
            })
            ->orderBy('start', 'desc')
            ->take(10)
            ->get();
        $newsitems = [];

        $counter = 0;
        foreach ($news as $item) {
            $newsitems[$counter] = [
                'title' => $item->title,
                'intro' => $item->intro,
                'body' => $item->body,
                'picture' => $item->picture
            ];
            ++$counter;
        }

        return $newsitems;
    }
    private function _getQuoteData()
    {
        $quotes = [];
        $quotes['hasquote'] = true;
        $quotes['title'] = 'Wat vonden anderen van Mon Ventoux';
        $quotes['quote'] = $this->_getRandomQuote();
        $quotes['show_cta'] = false;
        $quotes['cta_btn_lbl'] = '<small>Vertel ons uw</small>Motivatie';
        $quotes['cta_btn_href'] = '#';
        return $quotes;
    }

    /**
     * Get a random quote Model record
     * @return quote object
     */
    private function _getRandomQuote()
    {
        // get quote OLM...
        $quotes = Quote::all(array('img', 'name', 'txt'));
        /*
        $quotes=[
            [
                'img' => 'assets/img/hendrikvos.png',
                'name' => 'Hendrik Vos',
                'age' => '',
                'txt' => 'Toporganisatie, echt het enige wat je moet doen is trappen! Alles, maar dan ook alles is geregeld.'
            ],
            [
                'img' => 'assets/img/bartwellens.jpg',
                'name' => 'Bart Wellens',
                'age' => '',
                'txt' => 'Mon Ventoux is mijn uitdaging om op een gezonde manier opnieuw de liefde voor de fiets te ontdekken.'
            ]
        ];
        */
        
        $quote = $quotes[rand(0, (count($quotes)-1))];
        return $quote;

    }

    /**
     * Get a random banner Model record
     * @return banner object
     */
    private function _getRandomBanner()
    {
        // get banner OLM...
        $banners = [
            [
                'href' => url('/p/vrijwilliger'),
                'img' => asset('/assets/img/vrijwilligers/banner-vrijwilligers.jpg'),
                'hasbanner' => true
            ],
            [
                'href' => url('/webshop/producten'),
                'img' => asset('/assets/img/outfit/banner-outfit.gif'),
                'hasbanner' => true
            ]
        ];
        $banner = $banners[rand(0, (count($banners)-1))];
        return $banner;

    }

    /**
     * Get an array images (and videos) with given length
     * @param array $feed
     * @return array of images (or videos)
     */
    private function _getMediaData($feed)
    {
        $data = [];

        $count = count($feed);
        // replace with foreach loop of mediafiles
        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'small' => $feed[$i]['small'],
                'alt' => 'Mon Ventoux 2016',
                'large' => $feed[$i]['large'],
                'type' => $feed[$i]['type']
            ];
        }

        return $data;
    }

    private function _getMenuItems()
    {
        $navitems = NavItems::orderBy('order')->get();
        $menuitems = [];
        $menuitems[] = [
            'label' => 'Home',
            'url' => url('/')
        ];

        foreach ($navitems as $navitem) {
            if ($navitem->page->active == 1) {

                $menuitems[] = [
                    'label' => $navitem->page->menulabel,
                    'url' => url($navitem->page->template->name . '/' . $navitem->page->path)
                ];
            }
        }

        return $menuitems;
    }

    private function _getFooterMenuItems()
    {
        $navitems = NavItems::orderBy('order')->get();
        $count = ceil((3 + count($navitems)) / 2);

        $menuitems = [];
        $menugroups = [];
        $index = 1;

        $menuitems[] = [
            'label' => 'Home',
            'url' => url('/')
        ];
//
        foreach ($navitems as $navitem) {
            if ($index == $count) {
                $menugroups[] = $menuitems;
                $index = 0;
                $menuitems = [];
            }
            if ($navitem->page->active == 1) {
                $menuitems[] = [
                    'label' => $navitem->page->menulabel,
                    'url' => url($navitem->page->template->name . '/' . $navitem->page->path)
                ];
                $index++;
            }
        }

        if (Auth::user()) {
            $menuitems[] = [
                'label' => 'Uw profiel',
                'url' => url('/gebruiker')
            ];
            $menuitems[] = [
                'label' => 'Uitloggen',
                'url' => url('/logout')
            ];
        } else {
            $menuitems[] = [
                'label' => 'Inloggen',
                'url' => url('/login')
            ];
            /*
            $menuitems[] = [
                'label' => 'Inschrijven',
                'url' => url('/inschrijven')
            ];
            */
        }

        $menugroups[] = $menuitems;
        return $menugroups;
    }

    private function _getPartnerData()
    {
        $partners = [];
        $partners['large'] = [];
        $partners['medium'] = [];
        $partners['small'] = [];

        $partners['large'][] = [
            "extraclass" => "medium-offset-1 large-offset-1",
            "name" => "Ethias",
            "src" => "assets/img/partners/l1.png"
        ];
        $partners['large'][] = [
            "extraclass" => "",
            "name" => "Lotto",
            "src" => "assets/img/partners/l2.png"
        ];
        $partners['large'][] = [
            "extraclass" => "",
            "name" => "Telenet",
            "src" => "assets/img/partners/l3.png"
        ];
        $partners['large'][] = [
            "extraclass" => "",
            "name" => "Christelijke Mutualiteit",
            "src" => "assets/img/partners/l4.png"
        ];
        $partners['large'][] = [
            "extraclass" => "end",
            "name" => "Vlaamse overheid",
            "src" => "assets/img/partners/l5.png"
        ];
        $partners['large'][] = [
            "extraclass" => "medium-offset-2 large-offset-2",
            "name" => "Brita",
            "src" => "assets/img/partners/l6.png"
        ];
        $partners['large'][] = [
            "extraclass" => "",
            "name" => "Het Nieuwsblad",
            "src" => "assets/img/partners/l7.png"
        ];
        $partners['large'][] = [
            "extraclass" => "",
            "name" => "Etixx",
            "src" => "assets/img/partners/l8.png"
        ];
        /*
        $partners['large'][] = [
            "extraclass" => "",
            "name" => "TomTom Bandit",
            "src" => "assets/img/partners/l9.png"
        ];
        */
        $partners['large'][] = [
            "extraclass" => "end",
            "name" => "Meli",
            "src" => "assets/img/partners/s10.png"
        ];

        /*
        $partners['medium'][] = [
            "extraclass" => "medium-offset-2 large-offset-2",
            "name" => "Grinta!",
            "src" => "assets/img/partners/s1.png"
        ];
        */
        $partners['medium'][] = [
            "extraclass" => "medium-offset-2 large-offset-2",
            "name" => "Bio Racer speedwear",
            "src" => "assets/img/partners/s2.png"
        ];
        $partners['medium'][] = [
            "extraclass" => "",
            "name" => "Eddy Merckx",
            "src" => "assets/img/partners/s3.png"
        ];
        /*
        $partners['medium'][] = [
            "extraclass" => "",
            "name" => "Vlaamse wielerschool",
            "src" => "assets/img/partners/s4.png"
        ];
        */
        $partners['medium'][] = [
            "extraclass" => "",
            "name" => "Volvo",
            "src" => "assets/img/partners/l11.png"
        ];
        $partners['medium'][] = [
            "extraclass" => "end",
            "name" => "JBC",
            "src" => "assets/img/partners/s9.png"
        ];
        /*
        $partners['medium'][] = [
            "extraclass" => "end",
            "name" => "La Provença",
            "src" => "assets/img/partners/s11.png"
        ];
        */
        $partners['small'][] = [
            "extraclass" => "medium-offset-2 large-offset-2",
            "name" => "ska",
            "src" => "assets/img/partners/s7.png"
        ];
        $partners['small'][] = [
            "extraclass" => "",
            "name" => "185 Coaching Center Marc Herremans",
            "src" => "assets/img/partners/s5.png"
        ];
        $partners['small'][] = [
            "extraclass" => "",
            "name" => "Errea",
            "src" => "assets/img/partners/l10.png"
        ];
        $partners['small'][] = [
            "extraclass" => "end",
            "name" => "Kortweg cycling travel",
            "src" => "assets/img/partners/s8.png"
        ];

        /*
        $partners['small'][] = [
            "extraclass" => "end",
            "name" => "Fit class",
            "src" => "assets/img/partners/s6.png"
        ];
        */

        return $partners;
    }

    private function _getHomeMediaData()
    {
        return [
            [
                'small' => asset('assets/img/home/images/small-1.jpg'),
                'large' => asset('assets/img/home/images/large-1.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/home/images/small-2.jpg'),
                'large' => asset('assets/img/home/images/large-2.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/home/images/small-3.jpg'),
                'large' => asset('assets/img/home/images/large-3.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/home/images/small-video.jpg'),
                'large' => 'https://player.vimeo.com/video/142378452?autoplay=1&color=ffffff&title=0&byline=0&portrait=0',
                'type' => 'video'
            ],
            [
                'small' => asset('assets/img/home/images/small-4.jpg'),
                'large' => asset('assets/img/home/images/large-4.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/home/images/small-5.jpg'),
                'large' => asset('assets/img/home/images/large-5.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/home/images/small-6.jpg'),
                'large' => asset('assets/img/home/images/large-6.jpg'),
                'type' => 'image'
            ]
        ];

    }

    private function _getVentouristData()
    {
        return [
            [
                'small' => asset('assets/img/ventourist/small-1.jpg'),
                'large' => asset('assets/img/ventourist/large-1.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/ventourist/small-2.jpg'),
                'large' => asset('assets/img/ventourist/large-2.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/ventourist/small-3.jpg'),
                'large' => asset('assets/img/ventourist/large-3.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/ventourist/small-4.jpg'),
                'large' => asset('assets/img/ventourist/large-4.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/ventourist/small-5.jpg'),
                'large' => asset('assets/img/ventourist/large-5.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/ventourist/small-6.jpg'),
                'large' => asset('assets/img/ventourist/large-6.jpg'),
                'type' => 'image'
            ]
        ];

    }

    private function _getCannibaleData()
    {
        return [
            [
                'small' => asset('assets/img/lacannibale/small-1.jpg'),
                'large' => asset('assets/img/lacannibale/large-1.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibale/small-2.jpg'),
                'large' => asset('assets/img/lacannibale/large-2.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibale/small-3.jpg'),
                'large' => asset('assets/img/lacannibale/large-3.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibale/small-4.jpg'),
                'large' => asset('assets/img/lacannibale/large-4.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibale/small-5.jpg'),
                'large' => asset('assets/img/lacannibale/large-5.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibale/small-6.jpg'),
                'large' => asset('assets/img/lacannibale/large-6.jpg'),
                'type' => 'image'
            ]
        ];

    }

    private function _getCannibaletteData()
    {
        return [
            [
                'small' => asset('assets/img/lacannibalette/small-1.jpg'),
                'large' => asset('assets/img/lacannibalette/large-1.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibalette/small-2.jpg'),
                'large' => asset('assets/img/lacannibalette/large-2.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibalette/small-3.jpg'),
                'large' => asset('assets/img/lacannibalette/large-3.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibalette/small-4.jpg'),
                'large' => asset('assets/img/lacannibalette/large-4.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibalette/small-5.jpg'),
                'large' => asset('assets/img/lacannibalette/large-5.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibalette/small-6.jpg'),
                'large' => asset('assets/img/lacannibalette/large-6.jpg'),
                'type' => 'image'
            ]
        ];

    }

    private function _getTomSimpsonData()
    {
        return [
            [
                'small' => asset('assets/img/lacannibalette/small-1.jpg'),
                'large' => asset('assets/img/lacannibalette/large-1.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibalette/small-2.jpg'),
                'large' => asset('assets/img/lacannibalette/large-2.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibalette/small-3.jpg'),
                'large' => asset('assets/img/lacannibalette/large-3.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibalette/small-4.jpg'),
                'large' => asset('assets/img/lacannibalette/large-4.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibalette/small-5.jpg'),
                'large' => asset('assets/img/lacannibalette/large-5.jpg'),
                'type' => 'image'
            ],
            [
                'small' => asset('assets/img/lacannibalette/small-6.jpg'),
                'large' => asset('assets/img/lacannibalette/large-6.jpg'),
                'type' => 'image'
            ]
        ];

    }

    private function _getCalendarDates()
    {
        $dates = [
            [
                'class' => '',
                'date' => '17 + 18 okt',
                'label' => 'Kick-off Mon Ventoux campagne',
                'link' => ''
            ],
            [
                'class' => '',
                'date' => '05 maart',
                'label' => 'MV-dag Zolder',
                'link' => '/public/voorbereiden/ritten/info/1'
            ],
            [
                'class' => '',
                'date' => '19 maart',
                'label' => 'MV-dag Tongerlo',
                'link' => '/public/voorbereiden/ritten/info/2'
            ],
            [
                'class' => '',
                'date' => '10 april',
                'label' => 'MV-dag Tervuren',
                'link' => '/public/voorbereiden/ritten/info/3'
            ],
            [
                'class' => '',
                'date' => '24 april',
                'label' => 'MV-dag Riemst',
                'link' => '/public/voorbereiden/ritten/info/4'
            ],
            [
                'class' => '',
                'date' => '08 mei',
                'label' => 'MV-dag Oudenaarde',
                'link' => '/public/voorbereiden/ritten/info/5'
            ],
            [
                'class' => '',
                'date' => '21 mei',
                'label' => 'MV-dag Houffalize',
                'link' => '/public/voorbereiden/ritten/info/6'
            ],
            [
                'class' => '',
                'date' => '22 mei',
                'label' => 'Marc Herremans Challenge Houffalize',
                'link' => '/public/voorbereiden/ritten/info/7'
            ],
            [
                'class' => '',
                'date' => '29 mei',
                'label' => 'MV-dag Herbesthal',
                'link' => '/public/voorbereiden/ritten/info/8'
            ],
            [
                'class' => 'final',
                'date' => '18 juni',
                'label' => 'Mon Ventoux 2016',
                'link' => ''
            ]
        ];
        return $dates;
    }
}