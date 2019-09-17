<template>
    <div class="container">

        <div
            class="card tracking-card text-black mb-5 mx-auto"
            :class="{'bg-danger': isWorkState, 'bg-success': !isWorkState}"
        >
            <div class="card-header text-center timer-view">{{ timerView }}</div>
            <div class="card-body">
                <h5 class="card-title text-center">
                    <template v-if="isWorkState">
                        <template v-if="isTimerInactiveState">
                            <button @click="startTimer" class="btn" :title="startTimerMess"><i class="fa fa-play"></i></button>
                        </template>
                        <template v-else-if="isTimerActiveState">
                            <button @click="pauseTimer" class="btn" :title="pauseTimerMess"><i class="fa fa-pause"></i></button>
                            <button @click="stopTimer" class="btn" :title="stopTimerMess"><i class="fa fa-stop"></i></button>
                        </template>
                        <template v-else-if="isTimerPauseState">
                            <button @click="startTimer" class="btn" :title="startTimerMess"><i class="fa fa-play"></i></button>
                            <button @click="stopTimer" class="btn" :title="stopTimerMess"><i class="fa fa-stop"></i></button>
                            <button @click="finishTimer" class="btn" :title="finishTimerMess"><i class="fa fa-check"></i></button>
                        </template>
                    </template>
                    <template v-else-if="isRestState || isLongRestState">
                        <template v-if="isTimerInactiveState || isTimerPauseState">
                            <button @click="startTimer" class="btn" :title="startTimerMess"><i class="fa fa-play"></i></button>
                        </template>
                        <template v-else-if="isTimerActiveState">
                            <button @click="pauseTimer" class="btn" :title="pauseTimerMess"><i class="fa fa-pause"></i></button>
                        </template>
                        <button @click="finishTimer" class="btn" :title="finishTimerMess"><i class="fa fa-check"></i></button>
                    </template>
                </h5>
                <p class="card-text text-center">
                    {{ workStateDescription }}
                </p>
            </div>
            <div class="card-footer text-muted">
                <ProgressBar :percentage="timeLeftPercentage"></ProgressBar>
            </div>
        </div>
    </div>
</template>

<script>
    import ProgressBar from "./ProgressBar";
    import WorkState from "../state/Work";
    import TimerState from "../state/Timer";

    const TRACKING_WORK_STATE_STORAGE_ID = 'TRACKING_WORK_STATE';
    const TRACKING_POMIDOR_NUMBER_STORAGE_ID = 'TRACKING_POMIDOR_NUMBER';
    const TRACKING_LAST_VISIT_STORAGE_ID = 'TRACKING_LAST_VISIT';

    export default {
        data: function () {
            return {
                // Work or rest.
                workState: WorkState.WORK,
                // Current number of passed pomidors.
                pomidorNumber: 1,
                timerIntervalId: null,
                timerState: TimerState.INACTIVE,
                // Seconds left to changing work state.
                timerSecondsLeft: this.$store.state.settings.pomidorDuration * 60,

                // Localized messages.
                startTimerMess: transMessages['START_TIMER'],
                pauseTimerMess: transMessages['PAUSE_TIMER'],
                stopTimerMess: transMessages['STOP_TIMER'],
                finishTimerMess: transMessages['FINISH_TIMER'],
            };
        },
        /**
         * Reset pomidor number and work state on each new day.
         */
        created: function() {
            let lastVisitTimestamp = localStorage.getItem(TRACKING_LAST_VISIT_STORAGE_ID);
            if (!lastVisitTimestamp) {
                localStorage.setItem(TRACKING_LAST_VISIT_STORAGE_ID, (new Date()).getTime());
                return;
            }

            let currentDate = new Date();
            currentDate.setHours(0,0,0,0);
            let previousDate = new Date(parseInt(lastVisitTimestamp));
            previousDate.setHours(0,0,0,0);

            if (currentDate.getTime() === previousDate.getTime()) {
                let previousWorkState = localStorage.getItem(TRACKING_WORK_STATE_STORAGE_ID);
                if (previousWorkState) {
                    this.workState = previousWorkState;
                }

                let previousPomidorNumber = localStorage.getItem(TRACKING_POMIDOR_NUMBER_STORAGE_ID);
                if (previousPomidorNumber) {
                    this.pomidorNumber = parseInt(previousPomidorNumber);
                }
            } else {
                localStorage.setItem(TRACKING_LAST_VISIT_STORAGE_ID, currentDate.getTime());
            }
        },
        computed: {
            /**
             * User-friendly seconds left representation.
             * @returns {string}
             */
            timerView: function () {
                let minutesLeft = Math.floor(this.timerSecondsLeft / 60);
                let secondsLeft = this.timerSecondsLeft % 60;

                return `${zeroPadded(minutesLeft)}:${zeroPadded(secondsLeft)}`;
            },
            timeLeftPercentage: function () {
                return 100 - Math.floor(this.timerSecondsLeft * 100 / this.totalTimerSeconds);
            },
            totalTimerSeconds: function () {
                switch (this.workState) {
                    case WorkState.WORK:
                        return this.$store.state.settings.pomidorDuration * 60;
                    case WorkState.REST:
                        return this.$store.state.settings.shortRestDuration * 60;
                    case WorkState.LONG_REST:
                        return this.$store.state.settings.longRestDuration * 60;
                }
            },
            workStateDescription: function () {
                switch (this.workState) {
                    case WorkState.WORK:
                        return transMessages['POMIDOR_NUMBER'] + this.pomidorNumber;
                    case WorkState.REST:
                        return transMessages['REST'];
                    case WorkState.LONG_REST:
                        return transMessages['LONG_REST'];
                }
            },
            isWorkState: function () {
                return this.workState === WorkState.WORK;
            },
            isRestState: function () {
                return this.workState === WorkState.REST;
            },
            isLongRestState: function () {
                return this.workState === WorkState.LONG_REST;
            },
            isTimerActiveState: function () {
                return this.timerState === TimerState.ACTIVE;
            },
            isTimerPauseState: function () {
                return this.timerState === TimerState.PAUSE;
            },
            isTimerInactiveState: function () {
                return this.timerState === TimerState.INACTIVE;
            },
        },
        methods: {
            startTimer: function () {
                let self = this;
                this.timerIntervalId = setInterval(function () {
                    self.timerSecondsLeft--;
                }, 1000);
                this.timerState = TimerState.ACTIVE;
            },
            pauseTimer: function () {
                this.timerState = TimerState.PAUSE;
            },
            stopTimer: function () {
                this.timerState = TimerState.INACTIVE;
            },
            finishTimer: function () {
                this.stopTimer();
                this.changeWorkState();
            },
            changeWorkState: function () {
                switch (this.workState) {
                    case WorkState.WORK:
                        // On each n-th pomidor must be long rest.
                        if (this.pomidorNumber % this.$store.state.settings.longRestViaCountPomidors === 0) {
                            this.workState = WorkState.LONG_REST;
                        } else {
                            this.workState = WorkState.REST;
                        }
                        break;

                    case WorkState.REST:
                    case WorkState.LONG_REST:
                        this.workState = WorkState.WORK;
                        break;
                }
            },
            playSoundOnChangedWorkState: function () {
                if (this.$store.state.settings.needSoundTimerFinished) {
                    let audio = new Audio('sound/notification.mp3');
                    audio.play();
                }
            },
        },
        watch: {
            /**
             * Finish timer when seconds expired
             * @param secondsLeft
             */
            timerSecondsLeft: function(secondsLeft) {
                if (secondsLeft === 0) {
                    this.finishTimer();
                }
            },
            timerState: function (newState, oldState) {
                switch (newState) {
                    case TimerState.PAUSE:
                        clearInterval(this.timerIntervalId);
                        break;
                    case TimerState.INACTIVE:
                        clearInterval(this.timerIntervalId);
                        this.timerSecondsLeft = this.totalTimerSeconds;
                        break;
                }
            },
            workState: function (newState, oldState) {
                this.timerSecondsLeft = this.totalTimerSeconds;

                this.playSoundOnChangedWorkState();

                if (newState === WorkState.WORK) {
                    this.pomidorNumber++;
                }

                localStorage.setItem(TRACKING_WORK_STATE_STORAGE_ID, newState);
            },
            pomidorNumber: function (newPomidorNumber) {
                localStorage.setItem(TRACKING_POMIDOR_NUMBER_STORAGE_ID, newPomidorNumber);
            }
        },
        components: {
            ProgressBar,
        },
    }

    function zeroPadded(num) {
        return num < 10 ? `0${num}` : num;
    }
</script>
