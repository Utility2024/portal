<?php

namespace App\Zeus\Widgets;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Tabs;

class FormsWidget implements \LaraZeus\DynamicDashboard\Contracts\Widget
{
    use \LaraZeus\DynamicDashboard\Concerns\InteractWithWidgets;

    public function form(): Builder\Block
    {
        return Builder\Block::make('Forms')
            ->label(__('Forms'))
            ->schema([
                Tabs::make('Forms_tabs')
                    ->schema([
                        Tabs\Tab::make('Forms')
                            ->label(__('Forms'))
                            ->schema([
                                // add any filament components you want
                                MarkdownEditor::make('content')
                                    ->label(__('content'))
                                    ->required(),
                            ]),
                        $this->defaultOptionsTab(),
                    ]),
            ]);
    }

    /** pass any data to the widget view */
    public function viewData($data): array
    {
        return [];
    }
}

