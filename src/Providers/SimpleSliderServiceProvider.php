<?php

namespace Tec\SimpleSlider\Providers;

use Illuminate\Routing\Events\RouteMatched;
use Tec\Base\Traits\LoadAndPublishDataTrait;
use Tec\SimpleSlider\Models\SimpleSlider;
use Tec\SimpleSlider\Models\SimpleSliderItem;
use Tec\SimpleSlider\Repositories\Caches\SimpleSliderItemCacheDecorator;
use Tec\SimpleSlider\Repositories\Eloquent\SimpleSliderItemRepository;
use Tec\SimpleSlider\Repositories\Interfaces\SimpleSliderItemInterface;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Tec\SimpleSlider\Repositories\Caches\SimpleSliderCacheDecorator;
use Tec\SimpleSlider\Repositories\Eloquent\SimpleSliderRepository;
use Tec\SimpleSlider\Repositories\Interfaces\SimpleSliderInterface;
use Language;

class SimpleSliderServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(SimpleSliderInterface::class, function () {
            return new SimpleSliderCacheDecorator(new SimpleSliderRepository(new SimpleSlider));
        });

        $this->app->bind(SimpleSliderItemInterface::class, function () {
            return new SimpleSliderItemCacheDecorator(new SimpleSliderItemRepository(new SimpleSliderItem));
        });
    }

    public function boot()
    {
        $this
            ->setNamespace('plugins/simple-slider')
            ->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web'])
            ->loadMigrations()
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-simple-slider',
                'priority'    => 100,
                'parent_id'   => null,
                'name'        => 'plugins/simple-slider::simple-slider.menu',
                'icon'        => 'far fa-image',
                'url'         => route('simple-slider.index'),
                'permissions' => ['simple-slider.index'],
            ]);
        });

        $this->app->booted(function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                Language::registerModule([SimpleSlider::class]);
            }

            $this->app->register(HookServiceProvider::class);
        });
    }
}
