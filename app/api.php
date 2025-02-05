<?php
// api.php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

function apiRequest($method, $endpoint, $data = null) {
    $url = API_BASE_URL . $endpoint;
    $accessToken = getAccessToken();
    
    $ch = curl_init($url);
    
    $headers = [
        'X-Application-Key: ' . APPLICATION_KEY,
        'Authorization: Bearer ' . $accessToken,
        'Accept: application/json'
    ];
    
    // For POST/PUT/PATCH we need JSON body
    if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
        $headers[] = 'Content-Type: application/json';
        $body = $data ? json_encode($data) : '';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }
    
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
    
    return $response;
}

// --------------------
// Account
// --------------------
function getAccount() {
    return apiRequest('GET', '/me');
}

// --------------------
// Customers
// --------------------
function listCustomers() {
    return apiRequest('GET', '/customers');
}

function createCustomer($customerData) {
    return apiRequest('POST', '/customers', $customerData);
}

function getCustomer($id) {
    return apiRequest('GET', '/customers/' . $id);
}

function updateCustomer($id, $customerData) {
    return apiRequest('PUT', '/customers/' . $id, $customerData);
}

function deleteCustomer($id) {
    return apiRequest('DELETE', '/customers/' . $id);
}

// --------------------
// Customer Transactions
// --------------------
function listCustomerTransactions() {
    return apiRequest('GET', '/customers/transactions');
}

// --------------------
// Customer Offers
// --------------------
function listCustomerOffers() {
    return apiRequest('GET', '/customers/offers');
}

// --------------------
// Customer Available Coupons
// --------------------
function listCustomerCoupons() {
    return apiRequest('GET', '/customers/available-coupons');
}

// --------------------
// Customer Actions
// --------------------
function postCustomerAction($customerId, $actionData) {
    return apiRequest('POST', '/customers/' . $customerId . '/actions', $actionData);
}

// --------------------
// Claimable Offers
// --------------------
function listClaimableOffers() {
    return apiRequest('GET', '/claimable-offers');
}

// --------------------
// Customer Rewards
// --------------------
function listCustomerRewards($customerId) {
    return apiRequest('GET', '/customers/' . $customerId . '/rewards');
}

// --------------------
// Customer Consents
// --------------------
function listCustomerConsents($customerId) {
    return apiRequest('GET', '/customers/' . $customerId . '/consents');
}

function createCustomerConsent($customerId, $consentData) {
    return apiRequest('POST', '/customers/' . $customerId . '/consents', $consentData);
}

// --------------------
// Customer CRM fields
// --------------------
function getCustomerCRMFields($customerId) {
    return apiRequest('GET', '/customers/' . $customerId . '/crm-fields');
}

function updateCustomerCRMFields($customerId, $crmData) {
    return apiRequest('PUT', '/customers/' . $customerId . '/crm-fields', $crmData);
}

// --------------------
// Customer Targeted Offers
// --------------------
function listTargetedOffers($customerId) {
    return apiRequest('GET', '/customers/' . $customerId . '/targeted-offers');
}

// --------------------
// Transactions
// --------------------
function listTransactions() {
    return apiRequest('GET', '/transactions');
}

function createTransaction($transactionData) {
    return apiRequest('POST', '/transactions', $transactionData);
}

function cancelTransaction($transactionId) {
    return apiRequest('DELETE', '/transactions/' . $transactionId);
}

// --------------------
// Transaction Details
// --------------------
function updateTransactionDetails($transactionId, $detailsData) {
    return apiRequest('PUT', '/transactions/' . $transactionId, $detailsData);
}

// --------------------
// Rewards
// --------------------
function listRewards() {
    return apiRequest('GET', '/rewards');
}

function getReward($rewardId) {
    return apiRequest('GET', '/rewards/' . $rewardId);
}

function createReward($rewardData) {
    return apiRequest('POST', '/rewards', $rewardData);
}

// --------------------
// Product Rewards
// --------------------
function listProductRewards() {
    return apiRequest('GET', '/product-rewards');
}

// --------------------
// Offers
// --------------------
function createOffer($offerData) {
    return apiRequest('POST', '/offers', $offerData);
}

function listOffers() {
    return apiRequest('GET', '/offers');
}

function getOffer($offerId) {
    return apiRequest('GET', '/offers/' . $offerId);
}

function updateOffer($offerId, $offerData) {
    return apiRequest('PUT', '/offers/' . $offerId, $offerData);
}

function deleteOffer($offerId) {
    return apiRequest('DELETE', '/offers/' . $offerId);
}

// --------------------
// Offer Images
// --------------------
function uploadOfferImage($imagePath) {
    $url = API_BASE_URL . '/offers/images';
    $accessToken = getAccessToken();
    
    $ch = curl_init($url);
    $headers = [
        'X-Application-Key: ' . APPLICATION_KEY,
        'Authorization: Bearer ' . $accessToken,
        'Accept: application/json'
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    
    // Prepare file for upload
    if (function_exists('curl_file_create')) {
        $cFile = curl_file_create($imagePath);
    } else {
        $cFile = '@' . realpath($imagePath);
    }
    $data = ['file' => $cFile];
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
    return $response;
}

// --------------------
// Products
// --------------------
function createProduct($productData) {
    return apiRequest('POST', '/products', $productData);
}

function listProducts() {
    return apiRequest('GET', '/products');
}

// --------------------
// Branches
// --------------------
function listBranches() {
    return apiRequest('GET', '/branches');
}

// --------------------
// Tiers
// --------------------
function listTiers() {
    return apiRequest('GET', '/tiers');
}

// --------------------
// Referral Programs
// --------------------
function listReferralPrograms() {
    return apiRequest('GET', '/referral-programs');
}

function createReferralProgram($referralData) {
    return apiRequest('POST', '/referral-programs', $referralData);
}

// --------------------
// Business Rules
// --------------------
function getBusinessRules() {
    return apiRequest('GET', '/business-rules');
}

function updateBusinessRules($rulesData) {
    return apiRequest('PUT', '/business-rules', $rulesData);
}

// --------------------
// Workflow Main Triggers
// --------------------
function listWorkflowMainTriggers() {
    return apiRequest('GET', '/workflow/main-triggers');
}

// --------------------
// Workflow Main Actions
// --------------------
function listWorkflowMainActions() {
    return apiRequest('GET', '/workflow/main-actions');
}

// --------------------
// Workflows
// --------------------
function listWorkflows() {
    return apiRequest('GET', '/workflows');
}

function createWorkflow($workflowData) {
    return apiRequest('POST', '/workflows', $workflowData);
}

function updateWorkflow($workflowId, $workflowData) {
    return apiRequest('PUT', '/workflows/' . $workflowId, $workflowData);
}

function deleteWorkflow($workflowId) {
    return apiRequest('DELETE', '/workflows/' . $workflowId);
}

// --------------------
// Reviews
// --------------------
function listReviews() {
    return apiRequest('GET', '/reviews');
}

function createReview($reviewData) {
    return apiRequest('POST', '/reviews', $reviewData);
}

function updateReview($reviewId, $reviewData) {
    return apiRequest('PUT', '/reviews/' . $reviewId, $reviewData);
}

function getReviewSignedUrls($reviewId) {
    return apiRequest('GET', '/reviews/' . $reviewId . '/signed-urls');
}

function listPublishedReviews() {
    return apiRequest('GET', '/reviews/published');
}

function createReviewReply($reviewId, $replyData) {
    return apiRequest('POST', '/reviews/' . $reviewId . '/reply', $replyData);
}

function listReviewsAppSettings() {
    return apiRequest('GET', '/reviews/app-settings');
}

function updateReviewsAppSettings($settingsData) {
    return apiRequest('PUT', '/reviews/app-settings', $settingsData);
}

function createQuestion($questionData) {
    return apiRequest('POST', '/reviews/questions', $questionData);
}

function createReply($replyData) {
    return apiRequest('POST', '/reviews/replies', $replyData);
}
