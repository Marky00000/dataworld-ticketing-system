<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <title>[Dataworld Support] New Ticket Assigned: {{ $ticket->ticket_number }}</title>
    <style>
        body, table, td, p, a {
            font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
        }
        body {
            margin: 0;
            padding: 0;
            text-align: center;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: center;">
    
    <!-- Outlook Wrapper Table - Centered -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr>
            <td align="center" style="padding: 30px 15px;">
                
                <!-- Main Container - Centered -->
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; width: 100%; border-collapse: collapse; margin: 0 auto;" align="center">
                    
                    <!-- Header Section - No background, just centered text -->
                    <tr>
                        <td align="center" style="padding: 40px 0 20px 0;">
                            
                            <h1 style="margin: 0 0 10px 0; font-size: 32px; font-weight: 600;">
                                New Ticket Assigned
                            </h1>
                            
                            <!-- Ticket Number -->
                            <div style="margin-top: 10px;">
                                <span style="display: inline-block; padding: 8px 25px; border: 2px solid #e5e7eb; border-radius: 50px; font-size: 20px; font-weight: 600; letter-spacing: 1px;">
                                    {{ $ticket->ticket_number }}
                                </span>
                            </div>
                            
                            <!-- Assigned To/By Info -->
                            <p style="margin-top: 20px; color: #4b5563;">
                                Hello <strong>{{ $ticket->assignedTech->name }}</strong>,<br>
                                A new ticket has been assigned to you by <strong>{{ $assignedBy->name }}</strong> ({{ ucfirst($assignedBy->user_type) }})
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Content Section -->
                    <tr>
                        <td align="left" style="padding: 20px 0;">
                            
                            <!-- Priority, Category, Created - EXACT placement as reference -->
                            <div style="margin-bottom: 30px;">
                                <div style="margin-bottom: 5px;">
                                    <span style="font-weight: bold;">Priority:</span>
                                    <span style="margin-left: 10px; 
                                        @if($ticket->priority === 'high') color: #dc2626; @endif
                                        @if($ticket->priority === 'medium') color: #d97706; @endif
                                        @if($ticket->priority === 'low') color: #16a34a; @endif
                                        font-weight: 600; text-transform: uppercase;">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </div>
                                
                                <div style="margin-bottom: 5px;">
                                    <span style="font-weight: bold;">Category:</span>
                                    <span style="margin-left: 10px;">{{ $ticket->category->name ?? 'Uncategorized' }}</span>
                                </div>
                                
                                <div style="margin-bottom: 5px;">
                                    <span style="font-weight: bold;">Created:</span>
                                    <span style="margin-left: 10px;">{{ $ticket->created_at->format('F j, Y \a\t g:i A') }}</span>
                                </div>
                            </div>

                            <!-- Subject Section -->
                            <h2 style="font-size: 18px; font-weight: 600; margin: 25px 0 10px; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">
                                📋 Ticket Subject
                            </h2>
                            <div style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; margin: 15px 0;">
                                <strong style="font-size: 16px;">{{ $ticket->subject }}</strong>
                            </div>

                            <!-- Description Section -->
                            <h2 style="font-size: 18px; font-weight: 600; margin: 25px 0 10px; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">
                                📝 Description
                            </h2>
                            <div style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; margin: 15px 0;">
                                {{ nl2br(e($ticket->description)) }}
                            </div>

                            <!-- Contact Information -->
                            <h2 style="font-size: 18px; font-weight: 600; margin: 25px 0 10px; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">
                                👤 Contact Information
                            </h2>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 15px 0;">
                                <tr>
                                    <td width="50%" style="padding: 5px 10px 5px 0;">
                                        <strong style="color: #6b7280; font-size: 12px; display: block;">Name</strong>
                                        <span style="font-weight: 600;">{{ $ticket->contact_name ?? $ticket->creator->name }}</span>
                                    </td>
                                    <td width="50%" style="padding: 5px 0 5px 10px;">
                                        <strong style="color: #6b7280; font-size: 12px; display: block;">Email</strong>
                                        <span style="font-weight: 600;">{{ $ticket->contact_email ?? $ticket->creator->email }}</span>
                                    </td>
                                </tr>
                                @if($ticket->contact_phone || $ticket->contact_company)
                                <tr>
                                    @if($ticket->contact_phone)
                                    <td style="padding: 5px 10px 5px 0;">
                                        <strong style="color: #6b7280; font-size: 12px; display: block;">Phone</strong>
                                        <span style="font-weight: 600;">{{ $ticket->contact_phone }}</span>
                                    </td>
                                    @endif
                                    @if($ticket->contact_company)
                                    <td style="padding: 5px 0 5px 10px;">
                                        <strong style="color: #6b7280; font-size: 12px; display: block;">Company</strong>
                                        <span style="font-weight: 600;">{{ $ticket->contact_company }}</span>
                                    </td>
                                    @endif
                                </tr>
                                @endif
                            </table>

                            <!-- Device Information (if any) -->
                            @if($ticket->model || $ticket->firmware_version || $ticket->serial_number)
                            <h2 style="font-size: 18px; font-weight: 600; margin: 25px 0 10px; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px;">
                                💻 Device Information
                            </h2>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 15px 0;">
                                <tr>
                                    @if($ticket->model)
                                    <td width="33%" style="padding: 5px 10px 5px 0;">
                                        <strong style="color: #6b7280; font-size: 12px; display: block;">Model</strong>
                                        <span style="font-weight: 600;">{{ $ticket->model }}</span>
                                    </td>
                                    @endif
                                    @if($ticket->firmware_version)
                                    <td width="33%" style="padding: 5px 10px;">
                                        <strong style="color: #6b7280; font-size: 12px; display: block;">Firmware</strong>
                                        <span style="font-weight: 600;">{{ $ticket->firmware_version }}</span>
                                    </td>
                                    @endif
                                    @if($ticket->serial_number)
                                    <td width="33%" style="padding: 5px 0 5px 10px;">
                                        <strong style="color: #6b7280; font-size: 12px; display: block;">Serial #</strong>
                                        <span style="font-weight: 600;">{{ $ticket->serial_number }}</span>
                                    </td>
                                    @endif
                                </tr>
                            </table>
                            @endif

                            <!-- Attachments (if any) -->
                            @if($ticket->attachments && count(json_decode($ticket->attachments, true)) > 0)
                            @php $attachments = json_decode($ticket->attachments, true); @endphp
                            <div style="background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 15px; margin: 20px 0;">
                                <strong style="color: #0369a1; display: block; margin-bottom: 10px;">📎 Attachments ({{ count($attachments) }})</strong>
                                <ul style="margin: 0; padding-left: 20px;">
                                    @foreach($attachments as $attachment)
                                    <li style="margin-bottom: 5px; color: #0369a1;">{{ $attachment['name'] }} ({{ round($attachment['size'] / 1024) }} KB)</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                           <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 30px 0 20px;" align="center">
                                <tr>
                                    <td align="center">
                                        <!-- View Ticket Button -->
                                        <table cellpadding="0" cellspacing="0" border="0" style="display: inline-block; margin: 0 auto;" align="center">
                                            <tr>
                                                <td align="center" bgcolor="#4f46e5" style="background-color: #4f46e5; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                                    <a href="{{ route('tickets.my_tickets_view', $ticket->id) }}" 
                                                    style="display: inline-block; padding: 14px 32px; 
                                                            color: #ffffff; text-decoration: none; 
                                                            border-radius: 8px; font-weight: 600; 
                                                            font-size: 16px; letter-spacing: 0.5px;
                                                            border: 1px solid #4338ca;
                                                            background-color: #4f46e5;
                                                            transition: all 0.3s ease;">
                                                        📋  View This Ticket
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Divider -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 25px 0;">
                                <tr>
                                    <td style="border-top: 1px solid #e5e7eb;"></td>
                                </tr>
                            </table>

                            <!-- Footer Info - Centered -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr>
                                    <td align="center" style="color: #6b7280; font-size: 12px;">
                                        <p style="margin: 5px 0;">© {{ date('Y') }} Dataworld Computer Center. All rights reserved.</p>
                                        <p style="margin: 5px 0;">
                                            <a href="{{ route('tickets.index') }}" style="color: #667eea; text-decoration: none; margin: 0 5px;">My Tickets</a> |
                                            <a href="{{ route('dashboard') }}" style="color: #667eea; text-decoration: none; margin: 0 5px;">Dashboard</a> |
                                            <a href="mailto:support@dataworld.com.ph" style="color: #667eea; text-decoration: none; margin: 0 5px;">Contact Support</a>
                                        </p>
                                        <p style="margin: 5px 0; font-size: 11px;">This is an automated notification from the Dataworld Support Portal.</p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
    </table>
    
</body>
</html>