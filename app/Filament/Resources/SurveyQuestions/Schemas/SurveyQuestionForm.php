<?php

namespace App\Filament\Resources\SurveyQuestions\Schemas;

use Modules\Survey\Models\SurveyQuestion;
use Modules\Survey\Models\TracerStudySession;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;

class SurveyQuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECTION 1: BASIC QUESTION INFORMATION
                Section::make('📝 Informasi Dasar Pertanyaan')
                    ->description('Data dasar untuk pertanyaan survey')
                    ->icon('heroicon-m-document-text')
                    ->columns(2)
                    ->schema([
                        Select::make('session_id')
                            ->label('Sesi Tracer Study')
                            ->required()
                            ->options(TracerStudySession::query()
                                ->orderBy('year', 'desc')
                                ->get()
                                ->mapWithKeys(fn ($session) => [$session->session_id => $session->display_name])
                                ->toArray())
                            ->searchable()
                            ->preload()
                            ->helperText('Pilih sesi tracer study untuk pertanyaan ini')
                            ->columnSpan(2),

                        Textarea::make('question_text')
                            ->label('Teks Pertanyaan')
                            ->required()
                            ->rows(3)
                            ->maxLength(1000)
                            ->placeholder('Contoh: Bagaimana tingkat kepuasan Anda terhadap program studi yang telah ditempuh?')
                            ->helperText('Tuliskan pertanyaan survey yang jelas dan mudah dipahami')
                            ->columnSpanFull(),

                        Select::make('question_type')
                            ->label('Jenis Pertanyaan')
                            ->required()
                            ->options(SurveyQuestion::getQuestionTypes())
                            ->default(SurveyQuestion::TYPE_TEXT)
                            ->reactive()
                            ->helperText('Pilih jenis input yang sesuai untuk pertanyaan ini')
                            ->columnSpan(1),

                        TextInput::make('display_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->step(1)
                            ->helperText('Urutan pertanyaan dalam survey (angka kecil tampil lebih dulu)')
                            ->columnSpan(1),

                        Toggle::make('is_required')
                            ->label('Pertanyaan Wajib')
                            ->default(false)
                            ->helperText('Centang jika pertanyaan ini wajib dijawab')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                // SECTION 2: QUESTION TYPE SPECIFIC OPTIONS
                Section::make('⚙️ Pengaturan Khusus Jenis Pertanyaan')
                    ->description('Pengaturan tambahan berdasarkan jenis pertanyaan')
                    ->icon('heroicon-m-cog-6-tooth')
                    ->visible(fn ($get) => !empty($get('question_type')))
                    ->schema([
                        // OPTIONS FOR MULTIPLE CHOICE QUESTIONS
                        Repeater::make('options')
                            ->label('Pilihan Jawaban')
                            ->relationship('options')
                            ->visible(fn ($get) => in_array($get('question_type'), SurveyQuestion::getTypesWithOptions()))
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('option_text')
                                            ->label('Teks Pilihan')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Contoh: Sangat Puas')
                                            ->columnSpan(2),

                                        TextInput::make('weight')
                                            ->label('Bobot')
                                            ->numeric()
                                            ->default(0)
                                            ->helperText('Nilai untuk scoring (opsional)')
                                            ->columnSpan(1),
                                    ]),

                                TextInput::make('display_order')
                                    ->label('Urutan')
                                    ->numeric()
                                    ->default(fn ($get, $livewire) => 
                                        is_array($livewire->data['options'] ?? null) ? 
                                        count($livewire->data['options']) + 1 : 1
                                    )
                                    ->minValue(1)
                                    ->step(1)
                                    ->hidden(),
                            ])
                            ->addActionLabel('+ Tambah Pilihan')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['option_text'] ?? 'Pilihan kosong')
                            ->minItems(2)
                            ->maxItems(10)
                            ->helperText('Tambahkan pilihan jawaban untuk pertanyaan ini (minimal 2)')
                            ->columnSpanFull(),

                        // VALIDATION RULES
                        KeyValue::make('validation_rules')
                            ->label('Aturan Validasi')
                            ->keyLabel('Aturan')
                            ->valueLabel('Nilai')
                            ->visible(fn ($get) => !empty($get('question_type')))
                            ->helperText(function ($get) {
                                if (empty($get('question_type'))) return '';
                                
                                $model = new SurveyQuestion(['question_type' => $get('question_type')]);
                                $rules = $model->getValidationRulesForType();
                                
                                if (empty($rules)) {
                                    return 'Tidak ada aturan validasi khusus untuk jenis pertanyaan ini';
                                }
                                
                                $descriptions = [];
                                foreach ($rules as $rule => $description) {
                                    $descriptions[] = "• {$rule}: {$description}";
                                }
                                
                                return 'Aturan yang tersedia: ' . "\n" . implode("\n", $descriptions);
                            })
                            ->default(function ($get) {
                                if (empty($get('question_type'))) return [];
                                
                                $model = new SurveyQuestion(['question_type' => $get('question_type')]);
                                return $model->getDefaultValidationRules();
                            })
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                // SECTION 3: QUESTION PREVIEW
                Section::make('👀 Pratinjau Pertanyaan')
                    ->description('Lihat bagaimana pertanyaan akan tampil untuk responden')
                    ->icon('heroicon-m-eye')
                    ->visible(fn ($get) => !empty($get('question_text')) && !empty($get('question_type')))
                    ->schema([
                        Placeholder::make('question_preview')
                            ->label('')
                            ->content(function ($get, $record) {
                                $questionText = $get('question_text') ?: 'Teks pertanyaan akan tampil di sini...';
                                $questionType = $get('question_type') ?: 'text';
                                $isRequired = $get('is_required') ? ' *' : '';
                                
                                $typeDisplay = SurveyQuestion::getQuestionTypes()[$questionType] ?? 'Tidak Diketahui';
                                
                                $preview = "<div style='border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; background: #f9fafb;'>";
                                $preview .= "<strong style='color: #374151;'>{$questionText}{$isRequired}</strong>";
                                $preview .= "<div style='margin-top: 8px; font-size: 12px; color: #6b7280;'>Jenis: {$typeDisplay}</div>";
                                
                                // Show preview input based on type
                                $preview .= "<div style='margin-top: 12px;'>";
                                
                                switch ($questionType) {
                                    case SurveyQuestion::TYPE_TEXT:
                                        $preview .= "<input type='text' placeholder='Jawaban singkat...' style='width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;' disabled>";
                                        break;
                                        
                                    case SurveyQuestion::TYPE_TEXTAREA:
                                        $preview .= "<textarea placeholder='Jawaban panjang...' rows='3' style='width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;' disabled></textarea>";
                                        break;
                                        
                                    case SurveyQuestion::TYPE_RADIO:
                                        $options = $record?->options ?? collect($get('options') ?? []);
                                        if ($options->isNotEmpty()) {
                                            $optionIndex = 1;
                                            foreach ($options as $option) {
                                                $optionText = is_array($option) ? ($option['option_text'] ?? "Pilihan " . $optionIndex) : $option->option_text;
                                                $preview .= "<label style='display: block; margin: 4px 0;'><input type='radio' name='preview_radio' disabled> {$optionText}</label>";
                                                $optionIndex++;
                                            }
                                        } else {
                                            $preview .= "<div style='color: #9ca3af;'>Pilihan akan tampil di sini setelah ditambahkan...</div>";
                                        }
                                        break;
                                        
                                    case SurveyQuestion::TYPE_CHECKBOX:
                                        $options = $record?->options ?? collect($get('options') ?? []);
                                        if ($options->isNotEmpty()) {
                                            $optionIndex = 1;
                                            foreach ($options as $option) {
                                                $optionText = is_array($option) ? ($option['option_text'] ?? "Pilihan " . $optionIndex) : $option->option_text;
                                                $preview .= "<label style='display: block; margin: 4px 0;'><input type='checkbox' disabled> {$optionText}</label>";
                                                $optionIndex++;
                                            }
                                        } else {
                                            $preview .= "<div style='color: #9ca3af;'>Pilihan akan tampil di sini setelah ditambahkan...</div>";
                                        }
                                        break;
                                        
                                    case SurveyQuestion::TYPE_SELECT:
                                        $options = $record?->options ?? collect($get('options') ?? []);
                                        $preview .= "<select style='width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;' disabled>";
                                        $preview .= "<option>Pilih salah satu...</option>";
                                        if ($options->isNotEmpty()) {
                                            $optionIndex = 1;
                                            foreach ($options as $option) {
                                                $optionText = is_array($option) ? ($option['option_text'] ?? "Pilihan " . $optionIndex) : $option->option_text;
                                                $preview .= "<option>{$optionText}</option>";
                                                $optionIndex++;
                                            }
                                        }
                                        $preview .= "</select>";
                                        break;
                                        
                                    case SurveyQuestion::TYPE_RATING:
                                        $validationRules = $get('validation_rules') ?? [];
                                        $maxValue = $validationRules['max_value'] ?? 5;
                                        $preview .= "<div style='display: flex; gap: 8px; align-items: center;'>";
                                        for ($i = 1; $i <= $maxValue; $i++) {
                                            $preview .= "<label><input type='radio' name='preview_rating' value='{$i}' disabled> {$i}</label>";
                                        }
                                        $preview .= "</div>";
                                        break;
                                        
                                    case SurveyQuestion::TYPE_DATE:
                                        $preview .= "<input type='date' style='padding: 8px; border: 1px solid #d1d5db; border-radius: 4px;' disabled>";
                                        break;
                                }
                                
                                $preview .= "</div>";
                                $preview .= "</div>";
                                
                                return new \Illuminate\Support\HtmlString($preview);
                            })
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
