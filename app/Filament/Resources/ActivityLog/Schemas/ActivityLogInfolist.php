<?php

namespace App\Filament\Resources\ActivityLog\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ActivityLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('log_name')
                    ->label('Model'),
                TextEntry::make('description')
                    ->label('Action'),
                TextEntry::make('causer.name')
                    ->label('Changed By')
                    ->placeholder('System'),
                TextEntry::make('subject_type')
                    ->label('Subject Type'),
                TextEntry::make('subject_id')
                    ->label('Subject ID'),
                TextEntry::make('created_at')
                    ->label('Date & Time')
                    ->dateTime('Y-m-d H:i:s'),
                TextEntry::make('properties')
                    ->label('Changes')
                    ->columnSpanFull()
                    ->getStateUsing(function ($record) {
                        // Access the full properties from the record
                        $state = $record->getRawOriginal('properties') ?? $record->properties;
                        // Convert object to array
                        if (is_object($state)) {
                            $state = json_decode(json_encode($state), true);
                        }
                        // Decode if string
                        if (is_string($state)) {
                            $state = json_decode($state, true);
                        }
                        
                        if (empty($state)) {
                            return 'No changes recorded';
                        }
                        
                        $html = '<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">';
                        $html .= '<thead><tr style="background: #f5f5f5; border-bottom: 2px solid #ddd;">';
                        $html .= '<th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Field</th>';
                        $html .= '<th style="padding: 10px; text-align: left; border: 1px solid #ddd; background: #fff3cd;">Previous Value</th>';
                        $html .= '<th style="padding: 10px; text-align: left; border: 1px solid #ddd; background: #d4edda;">New Value</th>';
                        $html .= '</tr></thead>';
                        $html .= '<tbody>';
                        
                        // Get all fields from both old and attributes
                        $allFields = array_unique(array_merge(
                            array_keys($state['old'] ?? []),
                            array_keys($state['attributes'] ?? [])
                        ));
                        
                        foreach ($allFields as $field) {
                            $oldValue = isset($state['old'][$field]) ? (string)$state['old'][$field] : '---';
                            $newValue = isset($state['attributes'][$field]) ? (string)$state['attributes'][$field] : '---';
                            
                            // Check if value is HTML (contains HTML tags)
                            $isOldHtml = $oldValue !== '---' && preg_match('/<[^>]+>/', $oldValue);
                            $isNewHtml = $newValue !== '---' && preg_match('/<[^>]+>/', $newValue);
                            
                            // Format old value
                            $oldDisplay = $isOldHtml 
                                ? '<div style="border: 1px solid #ddd; padding: 5px; background: #f9f9f9; border-radius: 3px;">' . $oldValue . '</div>'
                                : htmlspecialchars($oldValue);
                            
                            // Format new value
                            $newDisplay = $isNewHtml 
                                ? '<div style="border: 1px solid #ddd; padding: 5px; background: #f9f9f9; border-radius: 3px;">' . $newValue . '</div>'
                                : htmlspecialchars($newValue);
                            
                            $html .= '<tr style="border-bottom: 1px solid #ddd;">';
                            $html .= '<td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">' . htmlspecialchars($field) . '</td>';
                            $html .= '<td style="padding: 10px; border: 1px solid #ddd; background: #fffbea; max-width: 400px; word-wrap: break-word; white-space: pre-wrap; vertical-align: top;">' . $oldDisplay . '</td>';
                            $html .= '<td style="padding: 10px; border: 1px solid #ddd; background: #f0f9f0; max-width: 400px; word-wrap: break-word; white-space: pre-wrap; vertical-align: top;">' . $newDisplay . '</td>';
                            $html .= '</tr>';
                        }
                        
                        $html .= '</tbody>';
                        $html .= '</table>';
                        
                        return new \Illuminate\Support\HtmlString($html);
                    })->html(),
            ]);
    }
}
