<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $invoice_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            border-bottom: 3px solid #28a745;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .company-info {
            float: left;
            width: 50%;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 5px;
        }
        
        .company-details {
            font-size: 12px;
            color: #666;
        }
        
        .invoice-info {
            float: right;
            width: 45%;
            text-align: right;
        }
        
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        
        .invoice-number {
            font-size: 16px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .invoice-date {
            font-size: 14px;
            color: #666;
        }
        
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        
        .customer-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
        }
        
        .customer-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        
        .customer-details {
            font-size: 14px;
            color: #555;
        }
        
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        
        .order-table th {
            background: #28a745;
            color: white;
            padding: 15px 10px;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
        }
        
        .order-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #dee2e6;
            font-size: 14px;
        }
        
        .order-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .product-name {
            font-weight: bold;
            color: #333;
        }
        
        .product-category {
            font-size: 12px;
            color: #666;
            font-style: italic;
        }
        
        .quantity-badge {
            background: #007bff;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .price {
            font-weight: bold;
            color: #333;
        }
        
        .subtotal {
            font-weight: bold;
            color: #28a745;
            font-size: 16px;
        }
        
        .totals {
            float: right;
            width: 300px;
            margin-top: 20px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .total-row.final {
            background: #28a745;
            color: white;
            font-weight: bold;
            font-size: 18px;
            border: none;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-ordered {
            background: #d4edda;
            color: #155724;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        
        .footer-note {
            margin-top: 15px;
            font-style: italic;
        }
        
        .eco-message {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            font-size: 13px;
        }
        
        .eco-icon {
            font-size: 16px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header clearfix">
        <div class="company-info">
            <div class="company-name">{{ $company['name'] }}</div>
            <div class="company-details">
                <strong>Adresse:</strong> {{ $company['address'] }}<br>
                <strong>Téléphone:</strong> {{ $company['phone'] }}<br>
                <strong>Email:</strong> {{ $company['email'] }}<br>
                <strong>Site web:</strong> {{ $company['website'] }}
            </div>
        </div>
        <div class="invoice-info">
            <div class="invoice-title">FACTURE</div>
            <div class="invoice-number">{{ $invoice_number }}</div>
            <div class="invoice-date">Date: {{ $invoice_date }}</div>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="customer-info">
        <div class="customer-title">Informations Client</div>
        <div class="customer-details">
            <strong>Nom:</strong> {{ $panier->user->first_name }} {{ $panier->user->last_name }}<br>
            <strong>Email:</strong> {{ $panier->user->email }}<br>
            @if($panier->user->phone)
                <strong>Téléphone:</strong> {{ $panier->user->phone }}<br>
            @endif
            <strong>Date de commande:</strong> {{ $panier->created_at->format('d/m/Y à H:i') }}<br>
            <strong>Statut:</strong> 
            <span class="status-badge status-ordered">{{ ucfirst($panier->status) }}</span>
        </div>
    </div>

    <!-- Eco Message -->
    <div class="eco-message">
        <span class="eco-icon">🌱</span>
        <strong>Merci pour votre engagement écologique !</strong> 
        Votre achat contribue à un avenir plus durable.
    </div>

    <!-- Order Details -->
    <table class="order-table">
        <thead>
            <tr>
                <th style="width: 15%;">Image</th>
                <th style="width: 35%;">Produit</th>
                <th style="width: 15%;">Prix Unitaire</th>
                <th style="width: 15%;">Quantité</th>
                <th style="width: 20%;">Sous-total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @if($panier->produit->image_url)
                        <img src="{{ public_path('storage/' . $panier->produit->image_url) }}" 
                             alt="{{ $panier->produit->name }}" 
                             class="product-image">
                    @else
                        <div style="width: 50px; height: 50px; background: #e9ecef; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 12px;">
                            Pas d'image
                        </div>
                    @endif
                </td>
                <td>
                    <div class="product-name">{{ $panier->produit->name }}</div>
                    @if($panier->produit->category)
                        <div class="product-category">Catégorie: {{ $panier->produit->category->name ?? 'N/A' }}</div>
                    @endif
                    @if($panier->produit->description)
                        <div style="font-size: 11px; color: #777; margin-top: 5px;">
                            {{ Str::limit($panier->produit->description, 80) }}
                        </div>
                    @endif
                </td>
                <td class="price">{{ number_format($panier->price, 2) }} DT</td>
                <td>
                    <span class="quantity-badge">{{ $panier->quantity }}</span>
                </td>
                <td class="subtotal">{{ $panier->formatted_subtotal }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Totals -->
    <div class="clearfix">
        <div class="totals">
            <div class="total-row">
                <span>Sous-total:</span>
                <span>{{ $panier->formatted_subtotal }}</span>
            </div>
            <div class="total-row">
                <span>TVA (0%):</span>
                <span>0.00 DT</span>
            </div>
            <div class="total-row">
                <span>Frais de livraison:</span>
                <span>Gratuit</span>
            </div>
            <div class="total-row final">
                <span>TOTAL:</span>
                <span>{{ $panier->formatted_subtotal }}</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>
            <strong>{{ $company['name'] }}</strong> - Plateforme de gestion d'événements écologiques
        </div>
        <div class="footer-note">
            Merci de votre confiance ! Pour toute question, contactez-nous à {{ $company['email'] }}
        </div>
        <div style="margin-top: 20px; font-size: 10px; color: #999;">
            Facture générée automatiquement le {{ now()->format('d/m/Y à H:i') }}
        </div>
    </div>
</body>
</html>