<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Message on Ticket #{{ $ticket->ticket_number }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 30px;
            background: white;
        }
        .ticket-info {
            background: #f8f9fa;
            border-left: 4px solid #6366f1;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .ticket-info h3 {
            margin: 0 0 10px;
            color: #333;
            font-size: 18px;
        }
        .ticket-info p {
            margin: 5px 0;
            color: #666;
        }
        .message-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .message-box p {
            margin: 0;
            font-style: italic;
            color: #0369a1;
        }
        .sender-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        .sender-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
            margin-right: 15px;
        }
        .sender-details h4 {
            margin: 0;
            color: #333;
        }
        .sender-details p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background: #6366f1;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            margin-top: 20px;
            transition: background 0.3s;
        }
        .button:hover {
            background: #4f46e5;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #e5e7eb;
        }
        .priority-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .priority-high { background: #fee2e2; color: #991b1b; }
        .priority-medium { background: #fef3c7; color: #92400e; }
        .priority-low { background: #dcfce7; color: #166534; }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-open { background: #dcfce7; color: #166534; }
        .status-in_progress { background: #dbeafe; color: #1e40af; }
        .status-resolved { background: #f3f4f6; color: #374151; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                @if($isTechSender)
                    🛠️ New Reply from Support
                @else
                    💬 New Message on Your Ticket
                @endif
            </h1>
            <p>Ticket #{{ $ticket->ticket_number }}</p>
        </div>
        
        <div class="content">
            <div class="sender-info">
                <div class="sender-avatar">
                    {{ substr($sender->name, 0, 1) }}
                </div>
                <div class="sender-details">
                    <h4>{{ $sender->name }}</h4>
                    <p>
                        @if($isTechSender)
                            Support Team • {{ ucfirst($sender->user_type) }}
                        @else
                            Ticket Creator • Client
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="ticket-info">
                <h3>Ticket Details</h3>
                <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
                <p><strong>Category:</strong> {{ $ticket->category->name ?? 'N/A' }}</p>
                <p>
                    <strong>Priority:</strong> 
                    <span class="priority-badge priority-{{ $ticket->priority }}">
                        {{ ucfirst($ticket->priority) }}
                    </span>
                </p>
                <p>
                    <strong>Status:</strong> 
                    <span class="status-badge status-{{ str_replace('_', '-', $ticket->status) }}">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                </p>
                @if($ticket->assignedTech)
                <p><strong>Assigned to:</strong> {{ $ticket->assignedTech->name }}</p>
                @endif
            </div>
            
            <div class="message-box">
                <p style="font-weight: 600; margin-bottom: 10px;">📝 Message:</p>
                <p>{{ $messageContent }}</p>  <!-- CHANGED: from $message to $messageContent -->
            </div>
            
            <div style="text-align: center;">
                <a href="{{ url('/conversation/ticket_update/' . $ticket->id) }}" class="button">
                    View Conversation
                </a>
            </div>
            
            <p style="margin-top: 20px; color: #666; font-size: 14px; text-align: center;">
                Click the button above to view the full conversation and reply.
            </p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Dataworld Computer Center. All rights reserved.</p>
            <p style="font-size: 12px; margin-top: 10px;">
                This is an automated message. Please do not reply directly to this email.
            </p>
        </div>
    </div>
</body>
</html>