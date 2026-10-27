<?php

test('legal pages preserve supplied text except the removed company introduction', function (string $url, string $hash) {
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

    // Digests come from the original Word text, excluding only the removed company introduction.
    expect(hash('sha256', $text))->toBe($hash);
    expect($xpath->query('//main//h1')->length)->toBe(1);
})->with([
    ['/privacy-policy', '4b0ad8e7d23b2767f5fe1968aedb690fe753a0f9aeb5343a5de25a89ef34b99a'],
    ['/terms-and-conditions', 'b94350418039b411c25eba41b83dc12776740199cc000d17b5400c470bd755f3'],
    ['/investment-terms-and-conditions', '2ddde152bc0a454366bf61eb817019bd29f9089642cfe21fc8667b89f5f709af'],
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
