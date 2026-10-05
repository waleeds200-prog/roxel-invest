<?php

test('public pages render successfully', function (string $url) {
    $this->get($url)->assertOk();
})->with(['/', '/our-dna', '/collection', '/bespoke', '/investor-relations']);

test('legacy services URL redirects permanently to the collection', function () {
    $this->get('/services')->assertRedirect('/collection')->assertStatus(301);
});

test('investor inquiry offers the current interest options', function () {
    $this->get('/investor-relations')
        ->assertOk()
        ->assertSee('<option value="Investment Portfolio"', false)
        ->assertSee('<option value="Cyprus Permanent Residency"', false);
});

test('collection gallery uses optimized WebP assets', function () {
    $this->get('/collection')
        ->assertOk()
        ->assertSee('City_Panorama/city1.webp')
        ->assertSee('AMATHOS_Photos_page-0001.webp')
        ->assertSee('Classic\/Classic_Bedroom.webp', false);
});

test('room designs include only available images for the selected room', function () {
    $response = $this->get('/collection')->assertOk();
    preg_match('/<script id="collection-gallery-data" type="application\/json">(.*?)<\/script>/s', $response->getContent(), $matches);
    $galleries = json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR);
    $rooms = $galleries['olea-mare']['images'];

    expect(array_column($rooms[1]['designs'], 'label'))->toBe(['Modern', 'Classic']);
    expect(array_column($rooms[3]['designs'], 'label'))->toBe(['Modern', 'Classic', 'Contemporary']);
    expect(array_column($rooms[5]['designs'], 'label'))->toBe(['Classic', 'Contemporary', 'Night Vibes']);
    foreach ($rooms as $room) {
        foreach ($room['designs'] as $design) {
            expect(is_file(public_path(rawurldecode(parse_url($design['src'], PHP_URL_PATH)))))->toBeTrue();
        }
    }
    expect($galleries['city-panorama']['images'][0])->not->toHaveKey('designs');
    expect($galleries['amathos-residences']['images'][0])->not->toHaveKey('designs');
});

test('home page presents the Roxel editorial experience', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('The New Riviera')
        ->assertSee('A Portfolio of Distinction')
        ->assertSee('Gateway to the European Union');
});

test('contact inquiry requires the essential fields', function () {
    $this->post('/contact', [])
        ->assertSessionHasErrors(['first_name', 'last_name', 'email', 'interest', 'message']);
});
