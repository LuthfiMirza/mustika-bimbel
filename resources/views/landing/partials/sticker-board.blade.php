<!-- 5.13 STICKER BOARD (sticker-board.blade.php) — Draggable Pointer Events -->
<section class="py-16 sm:py-24 bg-cream bg-dots relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center mb-10 reveal" x-intersect.once="$el.classList.add('is-in')">
            <h2 class="font-display-hero text-[36px] sm:text-[54px] lg:text-[72px] text-ink">
                <span>HIAS</span>
                <span class="sticker-headline sticker-headline--gold text-[0.82em] mx-1" style="--tilt: -3deg;">BUKU</span>
                <span>TUGASMU</span>
            </h2>
            <p class="font-script text-2xl sm:text-3xl text-navy mt-1">
                geser stikernya ke halaman buku tulis!
            </p>
        </div>

        <!-- Draggable Sticker Canvas -->
        <div x-data="{
                topZ: 10,
                draggingId: null,
                startX: 0,
                startY: 0,
                origX: 0,
                origY: 0,
                defaults: [
                    { id: 1, x: 10, y: 14, rot: -8, z: 2, mobile: true, type: 'mascot', pose: 'wave' },
                    { id: 2, x: 74, y: 12, rot: 10, z: 3, mobile: true, type: 'pill', text: '8 × 7 = 56', bg: 'bg-gold text-ink' },
                    { id: 3, x: 16, y: 66, rot: 6, z: 4, mobile: true, type: 'pill', text: 'E = mc²', bg: 'bg-lime text-ink' },
                    { id: 4, x: 68, y: 68, rot: -7, z: 5, mobile: true, type: 'pill', text: 'JAGO MIPA!', bg: 'bg-navy text-gold' },
                    { id: 5, x: 42, y: 16, rot: 5, z: 6, mobile: true, type: 'circle', text: 'π = 3,14', bg: 'bg-tomato text-white' },
                    { id: 6, x: 44, y: 68, rot: -5, z: 7, mobile: true, type: 'pill', text: '30 DTK', bg: 'bg-paper text-ink' },
                    { id: 7, x: 24, y: 38, rot: -10, z: 8, mobile: false, type: 'mascot', pose: 'thumbs' },
                    { id: 8, x: 78, y: 40, rot: 8, z: 9, mobile: false, type: 'pill', text: 'MUSTIKA BIMBEL', bg: 'bg-gold text-ink' },
                    { id: 9, x: 56, y: 42, rot: -4, z: 10, mobile: false, type: 'circle', text: '★ 100', bg: 'bg-lime text-ink' }
                ],
                stickers: [],
                init() {
                    this.resetPositions();
                },
                resetPositions() {
                    this.stickers = JSON.parse(JSON.stringify(this.defaults));
                    this.topZ = 12;
                },
                startDrag(e, item) {
                    this.draggingId = item.id;
                    this.topZ++;
                    item.z = this.topZ;
                    this.startX = e.clientX;
                    this.startY = e.clientY;
                    this.origX = item.x;
                    this.origY = item.y;
                    e.currentTarget.setPointerCapture(e.pointerId);
                },
                onDrag(e, item) {
                    if (this.draggingId !== item.id) return;
                    const rect = this.$refs.board.getBoundingClientRect();
                    const dxPct = ((e.clientX - this.startX) / rect.width) * 100;
                    const dyPct = ((e.clientY - this.startY) / rect.height) * 100;
                    item.x = Math.max(2, Math.min(82, this.origX + dxPct));
                    item.y = Math.max(4, Math.min(78, this.origY + dyPct));
                },
                stopDrag() {
                    this.draggingId = null;
                }
             }">

            <div x-ref="board"
                 role="img"
                 aria-label="Papan buku tulis interaktif dengan stiker bertema Matematika dan Jarimatika yang dapat digeser"
                 class="relative w-full aspect-[4/3] sm:aspect-[16/10] rounded-[24px] border-[3px] border-ink hard-shadow-lg bg-paper overflow-hidden select-none"
                 style="background-image: repeating-linear-gradient(to bottom, transparent 0px, transparent 31px, rgba(59,130,246,0.18) 32px); background-position: 0 18px;">

                <!-- Notebook Red Margin Line -->
                <div class="absolute inset-y-0 left-10 sm:left-16 w-[2px] bg-tomato/50 pointer-events-none"></div>

                <!-- Notebook Spiral Holes -->
                <div class="absolute inset-y-4 left-3 flex flex-col justify-between pointer-events-none">
                    @for ($hole = 0; $hole < 8; $hole++)
                        <span class="w-3.5 h-3.5 rounded-full bg-cream border-2 border-ink/50"></span>
                    @endfor
                </div>

                <!-- Subtle Watermark Label -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-15">
                    <span class="font-display text-3xl sm:text-5xl text-navy uppercase tracking-widest -rotate-6">
                        BUKU CATATAN MIPA
                    </span>
                </div>

                <!-- Draggable Stickers -->
                <template x-for="st in stickers" :key="st.id">
                    <div @pointerdown="startDrag($event, st)"
                         @pointermove="onDrag($event, st)"
                         @pointerup="stopDrag()"
                         @pointercancel="stopDrag()"
                         :class="[
                             st.mobile ? 'flex' : 'hidden sm:flex',
                             draggingId === st.id ? 'scale-110 shadow-[6px_6px_0_#111] cursor-grabbing' : 'cursor-grab hover:scale-105'
                         ]"
                         :style="`left: ${st.x}%; top: ${st.y}%; z-index: ${st.z}; transform: rotate(${draggingId === st.id ? 0 : st.rot}deg); touch-action: none;`"
                         class="absolute items-center justify-center transition-transform duration-100">

                        <template x-if="st.type === 'mascot'">
                            <div class="pointer-events-none drop-shadow-[3px_3px_0_#111]">
                                <template x-if="st.pose === 'wave'">
                                    <div>@include('landing.partials._mascot', ['pose' => 'wave', 'size' => 86, 'animate' => false])</div>
                                </template>
                                <template x-if="st.pose === 'thumbs'">
                                    <div>@include('landing.partials._mascot', ['pose' => 'thumbs', 'size' => 82, 'animate' => false])</div>
                                </template>
                            </div>
                        </template>

                        <template x-if="st.type === 'pill'">
                            <span :class="st.bg"
                                  class="px-3.5 sm:px-4 py-2 rounded-2xl border-[3px] border-ink shadow-[3px_3px_0_#111] font-display text-xs sm:text-base whitespace-nowrap"
                                  x-text="st.text"></span>
                        </template>

                        <template x-if="st.type === 'circle'">
                            <span :class="st.bg"
                                  class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border-[3px] border-ink shadow-[3px_3px_0_#111] font-display text-xs sm:text-sm flex items-center justify-center text-center leading-tight p-1"
                                  x-text="st.text"></span>
                        </template>
                    </div>
                </template>
            </div>

            <!-- Reset Button -->
            <div class="mt-4 flex justify-end">
                <button type="button" @click="resetPositions()"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border-2 border-ink bg-paper hover:bg-lime font-label text-xs font-bold uppercase text-ink shadow-[2px_2px_0_#111] transition-colors cursor-pointer">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    <span>Acak Ulang Stiker</span>
                </button>
            </div>
        </div>
    </div>
</section>
