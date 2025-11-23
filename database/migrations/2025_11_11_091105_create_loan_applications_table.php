<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('salary', 12, 2);
            $table->string('employment_type');
            $table->decimal('monthly_expenses', 12, 2)->default(0);
            $table->boolean('is_eligible')->default(false);
            $table->decimal('eligible_amount', 12, 2)->nullable();
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->integer('tenure_months')->nullable();
            $table->text('terms')->nullable();
            $table->decimal('processing_fee', 12, 2)->nullable();
            $table->enum('status', ['Pending', 'Verified', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamp('eligibility_checked_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_applications');
    }
}
