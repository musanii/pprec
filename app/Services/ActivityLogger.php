<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log( string $domain, string $action, $subject, array $properties = [])
    {
        ActivityLog::create([
            'domain' => $domain,
            'action' => $action,
            'subject_type' => get_class($subject),
            'subject_id' => $subject->id,
            'performed_by' => auth()->id(),                               
            'properties' => $properties,
        ]);
    }
}