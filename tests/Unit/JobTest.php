<?php

use App\Models\Employer;
use App\Models\Job;

test('it belongs to an employer', function () {
    //AAA (Arrange, Act, Assert)
    //Arrange
    $employer = Employer::factory()->create();
    $job = Job::factory()->create([
        'employer_id' => $employer->id,
    ]);

    //Act
    expect($job->employer->is($employer))->toBeTrue();
    //Assert
});

it('can have tags', function () {
    $job = Job::factory()->create();
    $job->tag('Frontend');
    expect($job->tags)->toHaveCount(1);
});
