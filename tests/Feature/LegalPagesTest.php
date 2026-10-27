<?php

test('legal pages preserve the complete supplied document text', function (string $url, string $hash) {
    $response = $this->get($url)->assertOk();
    $document = new DOMDocument;
    @$document->loadHTML('<?xml encoding="UTF-8">'.$response->getContent());
    $xpath = new DOMXPath($document);
    $article = $xpath->query('//article[contains(@class, "legal-document")]')->item(0);

    expect($article)->not->toBeNull();

    $paragraphs = [];
    foreach ($xpath->query('.//h1 | .//h2 | .//p | .//li', $article) as $paragraph) {
        $paragraphs[] = $paragraph->textContent;
    }
    $text = trim(preg_replace('/\s+/u', ' ', implode(' ', $paragraphs)));

    // Digests were calculated independently from the original Word document paragraphs.
    expect(hash('sha256', $text))->toBe($hash);
    expect($xpath->query('//main//h1')->length)->toBe(1);
})->with([
    ['/privacy-policy', '6a645d62b6a96c4df4dc3ecd2d3bcbdff420975072c879b575804dea9dd7138a'],
    ['/terms-and-conditions', '47f23123789c270df5488bc96a2992387dd475994c79750eb314ec74ec35e3b5'],
    ['/investment-terms-and-conditions', 'a86ff2ad299692fa6c5ad7946591c7bc2b85a808efce6591e6d7d32627bd2ea9'],
]);

test('the shared footer links to all legal pages in the requested order', function () {
    $this->get('/')->assertOk()->assertSeeInOrder([
        'href="'.route('legal.terms').'"',
        'Terms and Conditions',
        'href="'.route('legal.privacy').'"',
        'Privacy Policy',
        'href="'.route('legal.investment').'"',
        'Investment Terms and Conditions',
    ], false);
});
