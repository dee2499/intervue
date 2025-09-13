<div class="video-recorder-container" x-data="videoRecorder()">
    <div class="mb-3">
        <video x-ref="videoPreview" class="w-100" autoplay muted style="max-height: 400px; background-color: #000;"></video>
    </div>

    <div class="d-flex justify-content-center mb-3">
        <template x-if="!recording && !recorded">
            <button @click="startRecording" class="btn btn-danger btn-lg rounded-circle" style="width: 70px; height: 70px;">
                <i class="fas fa-circle"></i>
            </button>
        </template>

        <template x-if="recording">
            <button @click="stopRecording" class="btn btn-danger btn-lg rounded-circle" style="width: 70px; height: 70px;">
                <i class="fas fa-stop"></i>
            </button>
        </template>

        <template x-if="recorded">
            <div>
                <button @click="resetRecording" class="btn btn-secondary me-2">
                    <i class="fas fa-redo"></i> Re-record
                </button>
                <button @click="submitRecording" class="btn btn-success" :disabled="uploading">
                    <span x-show="!uploading">
                        <i class="fas fa-upload"></i> Submit
                    </span>
                    <span x-show="uploading">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </span>
                </button>
            </div>
        </template>
    </div>

    <div x-show="recording" class="text-center mb-3">
        <div class="badge bg-danger fs-6">
            <i class="fas fa-circle fa-xs me-1"></i>
            Recording: <span x-text="formatTime(recordingTime)"></span>
        </div>
    </div>

    <div x-show="recorded" class="mb-3" x-ref="recordedVideoContainer"></div>

    <div class="alert alert-info">
        <small>Debug: recording: <span x-text="recording"></span>, recorded: <span x-text="recorded"></span>, chunks: <span x-text="recordedChunks.length"></span></small>
    </div>

    <div x-show="errorMessage" class="alert alert-danger" x-text="errorMessage"></div>

    <form id="video-form" method="POST" action="{{ route('submissions.store') }}" enctype="multipart/form-data" style="display: none;">
        @csrf
        <input type="hidden" name="question_id" value="{{ $questionId }}">
        <input type="file" name="video" x-ref="videoInput">
    </form>

    <script>
        function videoRecorder() {
            return {
                recording: false,
                recorded: false,
                uploading: false,
                recordingTime: 0,
                timerInterval: null,
                mediaRecorder: null,
                recordedChunks: [],
                errorMessage: '',
                stream: null,

                init() {
                    console.log('Video recorder initialized');
                    this.setupCamera();
                },

                async setupCamera() {
                    try {
                        console.log('Setting up camera...');

                        this.stream = await navigator.mediaDevices.getUserMedia({
                            video: true,
                            audio: true
                        });


                        this.$refs.videoPreview.srcObject = this.stream;
                        console.log('Camera setup successful');
                    } catch (err) {
                        this.errorMessage = 'Error accessing camera and microphone: ' + err.message;
                        console.error('Error accessing media devices.', err);
                    }
                },

                startRecording() {
                    console.log('Start recording called');

                    if (!this.stream) {
                        this.errorMessage = 'No media stream available. Please refresh the page and try again.';
                        return;
                    }

                    this.recordedChunks = [];
                    this.errorMessage = '';

                    try {
                        console.log('Creating MediaRecorder...');

                        this.mediaRecorder = new MediaRecorder(this.stream);
                        console.log('MediaRecorder created');

                        this.mediaRecorder.ondataavailable = (event) => {
                            console.log('Data available event, size:', event.data.size);
                            if (event.data.size > 0) {
                                this.recordedChunks.push(event.data);
                            }
                        };

                        this.mediaRecorder.onstop = () => {
                            console.log('Recording stopped, processing chunks:', this.recordedChunks.length);
                            try {

                                const blob = new Blob(this.recordedChunks, { type: 'video/webm' });

                                console.log('Blob created, size:', blob.size);


                                const url = URL.createObjectURL(blob);


                                const videoElement = document.createElement('video');
                                videoElement.src = url;
                                videoElement.className = 'w-100';
                                videoElement.controls = true;
                                videoElement.style.maxHeight = '400px';
                                videoElement.style.backgroundColor = '#000';

                                if (this.$refs.recordedVideoContainer) {
                                    this.$refs.recordedVideoContainer.innerHTML = '';
                                    this.$refs.recordedVideoContainer.appendChild(videoElement);
                                    console.log('Video element added to container');
                                } else {
                                    console.error('recordedVideoContainer ref not found');
                                }

                                const file = new File([blob], 'recording.webm', { type: 'video/webm' });

                                if (this.$refs.videoInput) {
                                    const dataTransfer = new DataTransfer();
                                    dataTransfer.items.add(file);
                                    this.$refs.videoInput.files = dataTransfer.files;
                                    console.log('File set to input');
                                } else {
                                    console.error('videoInput ref not found');
                                    const videoInput = document.querySelector('input[name="video"]');
                                    if (videoInput) {
                                        const dataTransfer = new DataTransfer();
                                        dataTransfer.items.add(file);
                                        videoInput.files = dataTransfer.files;
                                        console.log('File set to input using querySelector');
                                    } else {
                                        console.error('videoInput element not found using querySelector');
                                    }
                                }


                                this.recorded = true;
                                console.log('Recorded state set to true');
                            } catch (err) {
                                this.errorMessage = 'Error processing recording: ' + err.message;
                                console.error('Error processing recording:', err);
                            }
                        };


                        this.mediaRecorder.start();
                        this.recording = true;
                        this.startTimer();
                        console.log('Recording started');
                    } catch (err) {
                        this.errorMessage = 'Error starting recording: ' + err.message;
                        console.error('Error starting recording:', err);
                    }
                },

                stopRecording() {
                    console.log('Stop recording called');
                    if (this.mediaRecorder && this.mediaRecorder.state !== 'inactive') {
                        this.mediaRecorder.stop();
                        this.recording = false;
                        this.stopTimer();
                        console.log('Recording stopped');
                    }
                },

                resetRecording() {
                    console.log('Reset recording called');
                    this.recorded = false;
                    this.recordedChunks = [];
                    if (this.$refs.recordedVideoContainer) {
                        this.$refs.recordedVideoContainer.innerHTML = '';
                    }
                    if (this.$refs.videoInput) {
                        this.$refs.videoInput.value = '';
                    } else {
                        const videoInput = document.querySelector('input[name="video"]');
                        if (videoInput) {
                            videoInput.value = '';
                        }
                    }
                    this.recordingTime = 0;
                    console.log('Recording reset');
                },

                submitRecording() {
                    console.log('Submit recording called');
                    if (!this.recorded || this.uploading) return;

                    let hasFile = false;
                    if (this.$refs.videoInput && this.$refs.videoInput.files.length > 0) {
                        hasFile = true;
                    } else {
                        const videoInput = document.querySelector('input[name="video"]');
                        if (videoInput && videoInput.files.length > 0) {
                            hasFile = true;
                        }
                    }

                    if (!hasFile) {
                        this.errorMessage = 'No video file found. Please record again.';
                        return;
                    }

                    this.uploading = true;
                    this.errorMessage = '';

                    console.log('Submitting form');

                    const form = document.getElementById('video-form');
                    form.submit();
                },

                startTimer() {
                    this.timerInterval = setInterval(() => {
                        this.recordingTime++;
                    }, 1000);
                },

                stopTimer() {
                    if (this.timerInterval) {
                        clearInterval(this.timerInterval);
                        this.timerInterval = null;
                    }
                },

                formatTime(seconds) {
                    const mins = Math.floor(seconds / 60);
                    const secs = seconds % 60;
                    return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                }
            }
        }
    </script>
</div>
