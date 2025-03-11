<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

it('should be able to create a new question bigger than 255 characters', function () {
    // arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);

    // act :: agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    // assert :: verificar
    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', [
        'question' => str_repeat('*', 260) . '?',
    ]);
});

it('should check if ends with question mark?', function () {
    // arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);

    // act :: agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 10),
    ]);

    // assert :: verificar
    $request->assertSessionHasErrors(
        [
            'question' => 'Are you sure that is a question? It is missing a question mark in the end.',
        ]
    );
    assertDatabaseCount('questions', 0);
});

it('should have at least 10 characters', function () {

    // arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);

    // act :: agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    // assert :: verificar
    $request->assertSessionHasErrors(
        [
            'question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question']), ]
    );
    assertDatabaseCount('questions', 0);
});
