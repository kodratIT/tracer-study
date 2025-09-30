<?php

namespace App\Filament\Resources\SurveyQuestions\Tables;

use Modules\Survey\Models\SurveyQuestion;
use Modules\Survey\Models\TracerStudySession;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

class SurveyQuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_order')
                    ->label('#')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('info')
                    ->size('sm'),
                    
                TextColumn::make('session.display_name')
                    ->label('Sesi Tracer Study')
                    ->searchable(['year'])
                    ->sortable()
                    ->weight('medium')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->session?->display_name),
                    
                TextColumn::make('question_preview')
                    ->label('Pertanyaan')
                    ->searchable(['question_text'])
                    ->sortable(false)
                    ->weight('medium')
                    ->wrap()
                    ->description(fn ($record) => 'ID: ' . $record->question_id),
                    
                BadgeColumn::make('type_display_name')
                    ->label('Jenis')
                    ->colors([
                        'secondary' => SurveyQuestion::TYPE_TEXT,
                        'info' => SurveyQuestion::TYPE_TEXTAREA,
                        'success' => [SurveyQuestion::TYPE_RADIO, SurveyQuestion::TYPE_CHECKBOX, SurveyQuestion::TYPE_SELECT],
                        'warning' => SurveyQuestion::TYPE_RATING,
                        'primary' => SurveyQuestion::TYPE_DATE,
                    ])
                    ->formatStateUsing(fn ($state) => $state)
                    ->sortable('question_type'),
                    
                IconColumn::make('is_required')
                    ->label('Wajib')
                    ->boolean()
                    ->alignCenter()
                    ->trueIcon('heroicon-o-exclamation-circle')
                    ->falseIcon('heroicon-o-minus-circle')
                    ->trueColor('danger')
                    ->falseColor('gray')
                    ->tooltip(fn ($record) => $record->is_required ? 'Pertanyaan Wajib' : 'Pertanyaan Opsional'),
                    
                TextColumn::make('options_count')
                    ->label('Pilihan')
                    ->alignCenter()
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn ($state, $record) => 
                        $record->has_options ? $state : 'N/A'
                    )
                    ->tooltip(fn ($record) => 
                        $record->has_options ? 
                        "Jumlah pilihan jawaban: {$record->options_count}" : 
                        "Jenis pertanyaan ini tidak memerlukan pilihan"
                    )
                    ->toggleable(),
                    
                BadgeColumn::make('validation_rules')
                    ->label('Validasi')
                    ->formatStateUsing(function ($state) {
                        if (!$state || empty($state)) return 'Tidak ada';
                        return count($state) . ' aturan';
                    })
                    ->color(fn ($state) => !empty($state) ? 'success' : 'gray')
                    ->tooltip(function ($record) {
                        if (!$record->validation_rules || empty($record->validation_rules)) {
                            return 'Tidak ada aturan validasi';
                        }
                        
                        $rules = [];
                        foreach ($record->validation_rules as $key => $value) {
                            $rules[] = "{$key}: {$value}";
                        }
                        return implode(', ', $rules);
                    })
                    ->toggleable(),
                    
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('session_id')
                    ->label('Filter Sesi')
                    ->options(function () {
                        return TracerStudySession::query()
                            ->orderBy('year', 'desc')
                            ->get()
                            ->pluck('display_name', 'session_id')
                            ->toArray();
                    })
                    ->placeholder('Semua Sesi'),
                    
                SelectFilter::make('question_type')
                    ->label('Filter Jenis Pertanyaan')
                    ->options(SurveyQuestion::getQuestionTypes())
                    ->placeholder('Semua Jenis'),
                    
                SelectFilter::make('is_required')
                    ->label('Filter Status Wajib')
                    ->options([
                        1 => 'Wajib Dijawab',
                        0 => 'Opsional',
                    ])
                    ->placeholder('Semua Status'),
                    
                Filter::make('has_options')
                    ->label('Filter Pertanyaan dengan Pilihan')
                    ->form([
                        Select::make('has_options')
                            ->label('Jenis Pertanyaan')
                            ->options([
                                'with_options' => 'Dengan Pilihan Jawaban',
                                'without_options' => 'Tanpa Pilihan Jawaban',
                            ])
                            ->placeholder('Semua Jenis')
                            ->columnSpan(1),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!isset($data['has_options'])) {
                            return $query;
                        }
                        
                        if ($data['has_options'] === 'with_options') {
                            return $query->whereIn('question_type', SurveyQuestion::getTypesWithOptions());
                        } elseif ($data['has_options'] === 'without_options') {
                            return $query->whereNotIn('question_type', SurveyQuestion::getTypesWithOptions());
                        }
                        
                        return $query;
                    })
                    ->columns(1),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->modalHeading(fn ($record) => 'Pratinjau Pertanyaan: ' . $record->question_preview)
                    ->modalContent(function ($record) {
                        $content = '<div style="space-y-4">';
                        
                        // Question details
                        $content .= '<div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; background: #f9fafb;">';
                        $content .= '<h4 style="font-weight: bold; color: #374151; margin-bottom: 8px;">Informasi Pertanyaan</h4>';
                        $content .= '<p><strong>Sesi:</strong> ' . $record->session?->display_name . '</p>';
                        $content .= '<p><strong>Jenis:</strong> ' . $record->type_display_name . '</p>';
                        $content .= '<p><strong>Status:</strong> ' . ($record->is_required ? 'Wajib' : 'Opsional') . '</p>';
                        $content .= '<p><strong>Urutan:</strong> #' . $record->display_order . '</p>';
                        $content .= '</div>';
                        
                        // Question text
                        $content .= '<div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; background: white; margin-top: 16px;">';
                        $content .= '<h4 style="font-weight: bold; color: #374151; margin-bottom: 8px;">Teks Pertanyaan</h4>';
                        $content .= '<p style="font-size: 16px;">' . $record->question_text . ($record->is_required ? ' <span style="color: red;">*</span>' : '') . '</p>';
                        $content .= '</div>';
                        
                        // Options (if applicable)
                        if ($record->has_options && $record->options->isNotEmpty()) {
                            $content .= '<div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; background: white; margin-top: 16px;">';
                            $content .= '<h4 style="font-weight: bold; color: #374151; margin-bottom: 8px;">Pilihan Jawaban</h4>';
                            $content .= '<ul style="list-style-type: none; padding: 0;">';
                            
                            foreach ($record->options as $option) {
                                $weight = $option->weight != 0 ? " (Bobot: {$option->weight})" : '';
                                $content .= '<li style="padding: 4px 0; border-bottom: 1px solid #f3f4f6;">#{$option->display_order} - ' . $option->option_text . $weight . '</li>';
                            }
                            
                            $content .= '</ul>';
                            $content .= '</div>';
                        }
                        
                        // Validation rules (if any)
                        if (!empty($record->validation_rules)) {
                            $content .= '<div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; background: white; margin-top: 16px;">';
                            $content .= '<h4 style="font-weight: bold; color: #374151; margin-bottom: 8px;">Aturan Validasi</h4>';
                            $content .= '<ul style="list-style-type: none; padding: 0;">';
                            
                            foreach ($record->validation_rules as $rule => $value) {
                                $content .= '<li style="padding: 2px 0;">• <strong>' . $rule . ':</strong> ' . $value . '</li>';
                            }
                            
                            $content .= '</ul>';
                            $content .= '</div>';
                        }
                        
                        $content .= '</div>';
                        
                        return new \Illuminate\Support\HtmlString($content);
                    }),
                    
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Dipilih')
                        ->icon('heroicon-m-trash'),
                ]),
            ])
            ->defaultSort('session_id', 'desc')
            ->secondarySort('display_order', 'asc')
            ->striped()
            ->searchPlaceholder('Cari pertanyaan, sesi...')
            ->emptyStateHeading('Belum Ada Pertanyaan Survey')
            ->emptyStateDescription('Mulai dengan membuat pertanyaan survey pertama untuk sesi tracer study.')
            ->emptyStateIcon('heroicon-o-question-mark-circle');
    }
}
