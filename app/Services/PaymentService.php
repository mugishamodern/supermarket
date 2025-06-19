<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Process payment for an order
     */
    public function processPayment(Order $order, array $paymentData = [])
    {
        try {
            $paymentMethod = $order->paymentMethod;
            
            if (!$paymentMethod) {
                throw new \Exception('Payment method not found');
            }

            switch (strtolower($paymentMethod->name)) {
                case 'mobile money':
                    return $this->processMobileMoney($order, $paymentData);
                case 'credit/debit card':
                    return $this->processCardPayment($order, $paymentData);
                case 'cash on delivery':
                    return $this->processCashOnDelivery($order);
                default:
                    throw new \Exception('Unsupported payment method');
            }
        } catch (\Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'payment_method' => $order->paymentMethod?->name
            ]);
            
            return [
                'success' => false,
                'message' => 'Payment processing failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Process Mobile Money payment
     */
    private function processMobileMoney(Order $order, array $paymentData)
    {
        // This would integrate with MTN Mobile Money or Airtel Money APIs
        // For now, we'll simulate the process
        
        $requiredFields = ['phone_number', 'provider'];
        
        foreach ($requiredFields as $field) {
            if (!isset($paymentData[$field])) {
                throw new \Exception("Missing required field: {$field}");
            }
        }

        // Simulate API call to mobile money provider
        $response = $this->callMobileMoneyAPI($order, $paymentData);
        
        if ($response['success']) {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing'
            ]);
            
            return [
                'success' => true,
                'message' => 'Payment processed successfully',
                'transaction_id' => $response['transaction_id'] ?? null
            ];
        }
        
        return [
            'success' => false,
            'message' => $response['message'] ?? 'Payment failed'
        ];
    }

    /**
     * Process Card Payment
     */
    private function processCardPayment(Order $order, array $paymentData)
    {
        // This would integrate with a payment gateway like Stripe, PayPal, etc.
        // For now, we'll simulate the process
        
        $requiredFields = ['card_number', 'expiry_month', 'expiry_year', 'cvv'];
        
        foreach ($requiredFields as $field) {
            if (!isset($paymentData[$field])) {
                throw new \Exception("Missing required field: {$field}");
            }
        }

        // Simulate API call to payment gateway
        $response = $this->callCardPaymentAPI($order, $paymentData);
        
        if ($response['success']) {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing'
            ]);
            
            return [
                'success' => true,
                'message' => 'Payment processed successfully',
                'transaction_id' => $response['transaction_id'] ?? null
            ];
        }
        
        return [
            'success' => false,
            'message' => $response['message'] ?? 'Payment failed'
        ];
    }

    /**
     * Process Cash on Delivery
     */
    private function processCashOnDelivery(Order $order)
    {
        // For COD, we just mark the order as pending payment
        $order->update([
            'payment_status' => 'pending',
            'status' => 'processing'
        ]);
        
        return [
            'success' => true,
            'message' => 'Order placed successfully. Payment will be collected on delivery.',
            'transaction_id' => null
        ];
    }

    /**
     * Simulate Mobile Money API call
     */
    private function callMobileMoneyAPI(Order $order, array $paymentData)
    {
        // This is a simulation - replace with actual API integration
        $phoneNumber = $paymentData['phone_number'];
        $provider = $paymentData['provider'];
        
        // Simulate API response
        $success = rand(1, 10) > 2; // 80% success rate for demo
        
        if ($success) {
            return [
                'success' => true,
                'transaction_id' => 'MM_' . time() . '_' . $order->id,
                'message' => 'Payment initiated successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Insufficient funds or invalid phone number'
        ];
    }

    /**
     * Simulate Card Payment API call
     */
    private function callCardPaymentAPI(Order $order, array $paymentData)
    {
        // This is a simulation - replace with actual payment gateway integration
        $cardNumber = $paymentData['card_number'];
        $expiryMonth = $paymentData['expiry_month'];
        $expiryYear = $paymentData['expiry_year'];
        $cvv = $paymentData['cvv'];
        
        // Basic validation
        if (strlen($cardNumber) < 13 || strlen($cardNumber) > 19) {
            return [
                'success' => false,
                'message' => 'Invalid card number'
            ];
        }
        
        if (strlen($cvv) < 3 || strlen($cvv) > 4) {
            return [
                'success' => false,
                'message' => 'Invalid CVV'
            ];
        }
        
        // Simulate API response
        $success = rand(1, 10) > 1; // 90% success rate for demo
        
        if ($success) {
            return [
                'success' => true,
                'transaction_id' => 'CARD_' . time() . '_' . $order->id,
                'message' => 'Payment processed successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Payment declined by bank'
        ];
    }

    /**
     * Verify payment status
     */
    public function verifyPayment(Order $order)
    {
        // This would check with the payment provider to verify the payment status
        // For now, we'll return the current status
        
        return [
            'success' => true,
            'status' => $order->payment_status,
            'verified' => true
        ];
    }

    /**
     * Refund payment
     */
    public function refundPayment(Order $order, $amount = null)
    {
        try {
            $refundAmount = $amount ?? $order->total_amount;
            
            // This would integrate with the payment provider's refund API
            // For now, we'll simulate the process
            
            $response = $this->callRefundAPI($order, $refundAmount);
            
            if ($response['success']) {
                $order->update([
                    'payment_status' => 'refunded',
                    'status' => 'cancelled'
                ]);
                
                return [
                    'success' => true,
                    'message' => 'Refund processed successfully',
                    'refund_id' => $response['refund_id'] ?? null
                ];
            }
            
            return [
                'success' => false,
                'message' => $response['message'] ?? 'Refund failed'
            ];
        } catch (\Exception $e) {
            Log::error('Refund processing failed: ' . $e->getMessage(), [
                'order_id' => $order->id
            ]);
            
            return [
                'success' => false,
                'message' => 'Refund processing failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Simulate Refund API call
     */
    private function callRefundAPI(Order $order, $amount)
    {
        // This is a simulation - replace with actual refund API integration
        $success = rand(1, 10) > 1; // 90% success rate for demo
        
        if ($success) {
            return [
                'success' => true,
                'refund_id' => 'REFUND_' . time() . '_' . $order->id,
                'message' => 'Refund initiated successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Refund failed - please contact support'
        ];
    }
} 