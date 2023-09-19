<script setup>
import { Head, Link } from '@inertiajs/vue3';
// import { ref } from 'vue'

// const msg = ref('Hello World!')
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});


</script>

<template>
    <Head title="" />

    <div
      class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
      <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
        <Link
          v-if="$page.props.auth.user"
          :href="route('dashboard')"
          class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >
          Dashboard
        </Link>

        <template v-else>
          <Link
            :href="route('login')"
            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
          >
            Log in
          </Link>

          <Link
            v-if="canRegister"
            :href="route('register')"
            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
          >
            Register
          </Link>
        </template>
      </div>

      <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
          <div class="quiz-container" v-if="questionsLoaded">
            <h2 class="quizz-question">{{ currentQuestion.question }}</h2>
            <div class="options">
              <div
                v-for="(option, index) in currentQuestion.options"
                :key="index"
                @click="selectOption(index)"
                :class="{ selected: selectedOption === index }"
              >
                {{ option }}
              </div>
            </div>
            <a href="/special-question">
              <button>Special Question</button>
            </a>
            <button @click="nextQuestion" v-if="currentIndex < questions.length - 1">
              Next
            </button>
            <div v-else>
              <hr />
              <br />
              <br />
              <h3>Quiz Completed!</h3>
              <br />
              <br />
              <hr />
              <br />
              <br />
              <p>You got {{ score }} out of {{ questions.length }} questions correct.</p>
            </div>
          </div>
          <div v-else>
            <p>Loading questions...</p>
          </div>
        </div>
      </div>
    </div>
  </template>

<style>

</style>


<script>
export default {
  data() {


    return {
      questions: [],
      currentIndex: 0,
      selectedOption: null,
      score: 0,
      questionsLoaded: false, // Track if questions are loaded
    };
  },
  computed: {
    currentQuestion() {
      return this.questions[this.currentIndex];
    },
  },
  methods: {
    specialQuestion() {
    const specialQuestionText = "Claudia Piek do you want to be my girlfriend? Ass.Hugo Resende :)";
    console.log('Special Question Clicked');
    this.$router.push({ name: 'SpecialQuestion' });
    alert(specialQuestionText);
  },
    selectOption(index) {
      this.selectedOption = index;
    },
    nextQuestion() {
      if (this.selectedOption === this.currentQuestion.correctAnswer) {
        this.score++;
      }
      this.selectedOption = null;
      this.currentIndex++;
    },
    async fetchQuestions() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/questions');

        if (response.status == 200) {
          const responseData = await response.json();
          const data = responseData.data; // Access the 'data' property
          console.log(data);
          this.questions = data.map((item) => ({
            question: item.question.text, // Access the 'text' property
            options: item.question.options, // Access the 'options' property
            correctAnswer: item.correctAnswer,
          }));
          this.questionsLoaded = true;
          console.log(this.questions);
        } else {
          console.error('Failed to fetch questions.');
        }
      } catch (error) {
        console.error('An error occurred while fetching questions:', error);
      }
    },
  },
  mounted() {
    this.fetchQuestions(); // Fetch questions when the component is mounted
  },
};
</script>

<style>

/* .bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
} */
/* @media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
} */
</style>
