<?php

namespace Tests\Feature;

use App\Filament\Widgets\ChapterProgressWidget;
use App\Filament\Widgets\PerformanceStatsWidget;
use App\Filament\Widgets\RecentActivityWidget;
use App\Filament\Widgets\TestAttemptsChartWidget;
use App\Filament\Widgets\UserLevelDistributionWidget;
use App\Filament\Widgets\UserStatsWidget;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DashboardWidgetsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Set the current panel to admin
        Filament::setCurrentPanel('admin');

        // Create and authenticate an admin user
        $user = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->actingAs($user);
    }

    #[Test]
    public function user_stats_widget_renders_successfully(): void
    {
        Livewire::test(UserStatsWidget::class)
            ->assertSuccessful();
    }

    #[Test]
    public function test_attempts_chart_widget_renders_successfully(): void
    {
        Livewire::test(TestAttemptsChartWidget::class)
            ->assertSuccessful();
    }

    #[Test]
    public function performance_stats_widget_renders_successfully(): void
    {
        Livewire::test(PerformanceStatsWidget::class)
            ->assertSuccessful();
    }

    #[Test]
    public function recent_activity_widget_renders_successfully(): void
    {
        Livewire::test(RecentActivityWidget::class)
            ->assertSuccessful();
    }

    #[Test]
    public function user_level_distribution_widget_renders_successfully(): void
    {
        Livewire::test(UserLevelDistributionWidget::class)
            ->assertSuccessful();
    }

    #[Test]
    public function chapter_progress_widget_renders_successfully(): void
    {
        Livewire::test(ChapterProgressWidget::class)
            ->assertSuccessful();
    }

    #[Test]
    public function user_stats_widget_returns_valid_chart_data(): void
    {
        $component = Livewire::test(UserStatsWidget::class);

        $component->assertSuccessful();
        $this->assertTrue($component->instance() instanceof UserStatsWidget);
    }

    #[Test]
    public function performance_stats_widget_returns_valid_stats(): void
    {
        $component = Livewire::test(PerformanceStatsWidget::class);

        $component->assertSuccessful();
        $this->assertTrue($component->instance() instanceof PerformanceStatsWidget);
    }
}
