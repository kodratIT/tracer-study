# TRACER STUDY QUESTIONNAIRE - COMPREHENSIVE PLAN & WIREFRAME

## 📋 RESEARCH FINDINGS

### Database Schema Summary

**Tables Structure:**
```
tracer_study_sessions (4 records)
├── session_id (PK)
├── year
├── start_date
├── end_date  
├── description
├── is_active
└── timestamps

survey_questions (0 records)
├── question_id (PK)
├── session_id (FK → tracer_study_sessions)
├── question_text
├── question_type (text|textarea|radio|checkbox|select|rating|date)
├── display_order
├── is_required
├── validation_rules (JSON)
└── timestamps

survey_options (7 records)
├── option_id (PK)
├── question_id (FK → survey_questions)
├── option_text
├── weight
├── display_order
└── timestamps

survey_responses (0 records)
├── response_id (PK)
├── session_id (FK → tracer_study_sessions)
├── alumni_id (FK → alumni)
├── submitted_at
├── completion_status (draft|partial|completed)
├── metadata (JSON)
└── timestamps

answers (0 records)
├── answer_id (PK)
├── response_id (FK → survey_responses)
├── question_id (FK → survey_questions)
├── option_id (FK → survey_options) [nullable]
├── answer_text [nullable]
├── rating_value [nullable]
├── additional_data (JSON) [nullable]
└── timestamps
```

### Key Insights from Filament Admin:

1. **Question Types Supported:**
   - ✅ Text (short answer)
   - ✅ Textarea (long answer)
   - ✅ Radio (single choice)
   - ✅ Checkbox (multiple choice)
   - ✅ Select (dropdown)
   - ✅ Rating (1-5 scale)
   - ✅ Date (date picker)

2. **Validation Rules:**
   - Each question type has specific validation rules stored in JSON
   - Questions can be marked as required/optional
   - Options can have weights for scoring

3. **Response Flow:**
   ```
   Alumni → View Active Session
          → Start Survey (create draft response)
          → Answer Questions (save answers)
          → Submit Survey (mark as completed)
   ```

---

## 🎨 WIREFRAME DESIGN

### 1. Dashboard - Survey Card (Existing)
```
┌─────────────────────────────────────────────────────────┐
│  📊 Tracer Study Survey                                 │
│  ─────────────────────────────────────────────────────  │
│  [🟢 Aktif] Tracer Study 2024                          │
│  Periode: 1 Okt 2024 - 31 Des 2024                     │
│                                                          │
│  Status: Belum Mengisi                                  │
│  Progress: ░░░░░░░░░░ 0%                               │
│                                                          │
│  [ Mulai Isi Kuesioner → ]                             │
└─────────────────────────────────────────────────────────┘
```

### 2. Survey Introduction Page
```
┌──────────────────────────────────────────────────────────────┐
│  ← Kembali ke Dashboard                                      │
│                                                               │
│  📋 Tracer Study 2024                                        │
│  ═══════════════════════════════════════════════════════    │
│                                                               │
│  Selamat Datang!                                             │
│                                                               │
│  Tracer study ini bertujuan untuk mengetahui kondisi         │
│  alumni setelah lulus. Data yang Anda berikan akan          │
│  membantu kampus meningkatkan kualitas pendidikan.          │
│                                                               │
│  📊 Total Pertanyaan: 25                                     │
│  ⏱️  Estimasi Waktu: 10-15 menit                            │
│  📅 Batas Akhir: 31 Desember 2024                           │
│                                                               │
│  ℹ️  Informasi Penting:                                      │
│  • Data Anda akan dijaga kerahasiaannya                      │
│  • Jawablah dengan jujur dan lengkap                         │
│  • Anda dapat menyimpan draft dan melanjutkan nanti         │
│                                                               │
│  [Simpan Draft]          [Mulai Mengisi Survey →]          │
└──────────────────────────────────────────────────────────────┘
```

### 3. Survey Questionnaire Page
```
┌──────────────────────────────────────────────────────────────┐
│  📋 Tracer Study 2024            Progress: ████░░░░░░ 40%   │
│  ─────────────────────────────────────────────────────────  │
│                                                               │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ Pertanyaan 1 dari 25                           [Wajib] │ │
│  │                                                         │ │
│  │ Apakah Anda saat ini bekerja?  *                      │ │
│  │                                                         │ │
│  │ ○ Ya, bekerja                                          │ │
│  │ ○ Ya, wirausaha                                        │ │
│  │ ○ Melanjutkan studi                                    │ │
│  │ ○ Belum/tidak bekerja                                  │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                               │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ Pertanyaan 2 dari 25                       [Opsional]  │ │
│  │                                                         │ │
│  │ Nama perusahaan/instansi tempat bekerja                │ │
│  │                                                         │ │
│  │ ┌───────────────────────────────────────────────────┐ │ │
│  │ │ [Masukkan nama perusahaan...]                     │ │ │
│  │ └───────────────────────────────────────────────────┘ │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                               │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ Pertanyaan 3 dari 25                           [Wajib] │ │
│  │                                                         │ │
│  │ Berapa lama waktu tunggu untuk mendapat pekerjaan? *   │ │
│  │                                                         │ │
│  │ ┌─────┐                                                │ │
│  │ │  6  │ bulan                                          │ │
│  │ └─────┘                                                │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                               │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ Pertanyaan 4 dari 25                           [Wajib] │ │
│  │                                                         │ │
│  │ Seberapa puas Anda dengan program studi yang           │ │
│  │ telah ditempuh? *                                       │ │
│  │                                                         │ │
│  │ ○ 1  ○ 2  ● 3  ○ 4  ○ 5                              │ │
│  │ Tidak Puas ←──────────→ Sangat Puas                   │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                               │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ Pertanyaan 5 dari 25                       [Opsional]  │ │
│  │                                                         │ │
│  │ Saran untuk perbaikan program studi                     │ │
│  │                                                         │ │
│  │ ┌───────────────────────────────────────────────────┐ │ │
│  │ │                                                   │ │ │
│  │ │ [Tuliskan saran Anda...]                         │ │ │
│  │ │                                                   │ │ │
│  │ │                                                   │ │ │
│  │ └───────────────────────────────────────────────────┘ │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                               │
│  ⚠️  Anda belum mengisi 2 pertanyaan wajib                  │
│                                                               │
│  [← Sebelumnya]  [Simpan Draft]  [Selanjutnya →]           │
│                                                               │
└──────────────────────────────────────────────────────────────┘
```

### 4. Survey Review Page
```
┌──────────────────────────────────────────────────────────────┐
│  📋 Review Jawaban Anda                                      │
│  ─────────────────────────────────────────────────────────  │
│                                                               │
│  Periksa kembali jawaban Anda sebelum mengirim              │
│                                                               │
│  ✅ 23/25 Pertanyaan Terjawab                               │
│  ⚠️  2 Pertanyaan Wajib Belum Dijawab                        │
│                                                               │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ Status Pekerjaan                                       │ │
│  │ ─────────────────────────────────────────────────────  │ │
│  │ Ya, bekerja                                   [Edit ✏️ ] │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                               │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ Nama Perusahaan                                        │ │
│  │ ─────────────────────────────────────────────────────  │ │
│  │ PT. Technology Indonesia                      [Edit ✏️ ] │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                               │
│  ┌────────────────────────────────────────────────────────┐ │
│  │ Waktu Tunggu Pekerjaan                        ⚠️ Kosong │ │
│  │ ─────────────────────────────────────────────────────  │ │
│  │ Belum dijawab                                 [Edit ✏️ ] │ │
│  └────────────────────────────────────────────────────────┘ │
│                                                               │
│  [...21 pertanyaan lainnya...]                               │
│                                                               │
│  ⚠️  Lengkapi 2 pertanyaan wajib sebelum submit              │
│                                                               │
│  [← Kembali Edit]  [Simpan Draft]  [Submit Survey →]       │
└──────────────────────────────────────────────────────────────┘
```

### 5. Success Confirmation
```
┌──────────────────────────────────────────────────────────────┐
│                                                               │
│              ✅ Survey Berhasil Dikirim!                     │
│                                                               │
│  Terima kasih telah mengisi kuesioner Tracer Study 2024.    │
│  Jawaban Anda sangat berharga untuk pengembangan            │
│  program studi.                                               │
│                                                               │
│  📊 Response ID: #TS2024-00123                              │
│  📅 Dikirim pada: 15 Oktober 2024, 14:30 WIB                │
│                                                               │
│  [Lihat Ringkasan]          [Kembali ke Dashboard]          │
│                                                               │
└──────────────────────────────────────────────────────────────┘
```

---

## 🔧 IMPLEMENTATION PLAN

### Phase 1: Backend Foundation
**Duration: 2-3 hours**

#### 1.1 Create Missing Model - `Answer.php`
```php
Location: Modules/Survey/app/Models/Answer.php
Purpose: Handle individual answer records
Relations: 
- belongsTo SurveyResponse
- belongsTo SurveyQuestion
- belongsTo SurveyOption (nullable)
```

#### 1.2 Create Survey Controller for Alumni
```php
Location: app/Http/Controllers/Alumni/SurveyController.php
Methods:
- index(): Show active sessions list
- show(session): Show survey introduction
- start(session): Create draft response & redirect to questionnaire
- questionnaire(response): Show questions page
- saveProgress(response): Save draft answers (AJAX)
- review(response): Show review page
- submit(response): Submit final response
- answer(response, question): Answer individual question (AJAX)
```

#### 1.3 Create Routes
```php
Location: routes/web.php
Group: alumni.survey
Routes:
- GET  /alumni/survey → index
- GET  /alumni/survey/{session} → show
- POST /alumni/survey/{session}/start → start
- GET  /alumni/survey/response/{response} → questionnaire
- POST /alumni/survey/response/{response}/answer → answer
- POST /alumni/survey/response/{response}/save-draft → saveProgress
- GET  /alumni/survey/response/{response}/review → review
- POST /alumni/survey/response/{response}/submit → submit
```

### Phase 2: Frontend Implementation
**Duration: 4-5 hours**

#### 2.1 Dashboard Integration
**File:** `resources/views/alumni/dashboard.blade.php`
- Update survey card to show active session
- Add progress indicator
- Add CTA button

#### 2.2 Survey Views
```
resources/views/alumni/survey/
├── index.blade.php (List of sessions)
├── introduction.blade.php (Welcome page)
├── questionnaire.blade.php (Main survey form)
├── review.blade.php (Review answers)
└── success.blade.php (Thank you page)
```

#### 2.3 Components/Partials
```
resources/views/alumni/survey/partials/
├── question-types/
│   ├── text.blade.php
│   ├── textarea.blade.php
│   ├── radio.blade.php
│   ├── checkbox.blade.php
│   ├── select.blade.php
│   ├── rating.blade.php
│   └── date.blade.php
├── progress-bar.blade.php
└── validation-errors.blade.php
```

### Phase 3: JavaScript Interactivity
**Duration: 2-3 hours**

#### 3.1 Auto-save Draft
```javascript
Features:
- Auto-save every 30 seconds
- Save on field blur
- Show "Saving..." indicator
- Show "Saved at HH:MM" timestamp
```

#### 3.2 Client-side Validation
```javascript
Features:
- Real-time validation for required fields
- Character count for textarea
- Number validation for text inputs
- Date range validation
```

#### 3.3 Progress Tracking
```javascript
Features:
- Update progress bar on answer
- Calculate completion percentage
- Show answered/total questions
- Highlight unanswered required questions
```

### Phase 4: Validation & Testing
**Duration: 1-2 hours**

#### 4.1 Server-side Validation
```php
Validations:
- Check if session is active
- Check if alumni already submitted
- Validate required questions
- Validate answer formats
- Validate option selections
```

#### 4.2 Edge Cases
```
Test scenarios:
- Multiple tabs/windows open
- Session expires during filling
- Network disconnection
- Partial data loss
- Invalid question types
```

### Phase 5: Polish & UX Enhancements
**Duration: 1-2 hours**

#### 5.1 UI Enhancements
```
Features:
- Loading states
- Error messages
- Success animations
- Smooth scrolling
- Keyboard navigation
```

#### 5.2 Accessibility
```
Features:
- ARIA labels
- Focus management
- Screen reader support
- Keyboard shortcuts
```

---

## 📊 DATA FLOW

### Creating Survey Response
```
1. Alumni clicks "Mulai Isi Kuesioner"
   ↓
2. System checks if active session exists
   ↓
3. System checks if alumni already has response for this session
   ↓
4. IF NO RESPONSE:
   - Create new SurveyResponse (status: draft)
   - Redirect to questionnaire page
   ↓
5. IF RESPONSE EXISTS (draft/partial):
   - Load existing response
   - Continue from where left off
```

### Answering Questions
```
1. Alumni fills in answer
   ↓
2. On field blur/change:
   - Send AJAX request to save answer
   - Update/Insert Answer record
   - Update response completion_status
   ↓
3. Calculate completion percentage:
   - answered_required / total_required * 100
   ↓
4. Update progress bar
```

### Submitting Survey
```
1. Alumni clicks "Submit"
   ↓
2. Validate all required questions answered
   ↓
3. IF VALIDATION FAILS:
   - Show error messages
   - Highlight missing questions
   - Scroll to first error
   ↓
4. IF VALIDATION PASSES:
   - Update SurveyResponse:
     * completion_status = 'completed'
     * submitted_at = now()
   - Show success page
   - Send notification (optional)
```

---

## 🎯 KEY FEATURES

### Must Have (MVP):
- ✅ View active survey session
- ✅ Start new response
- ✅ Answer all question types
- ✅ Save draft (manual)
- ✅ Submit completed survey
- ✅ Validation for required fields
- ✅ Progress indicator

### Should Have:
- ✅ Auto-save draft
- ✅ Review page before submit
- ✅ Edit answers after review
- ✅ Character counter for textarea
- ✅ Real-time validation
- ✅ Responsive design

### Nice to Have:
- ⭕ Resume from last position
- ⭕ Keyboard shortcuts
- ⭕ Print survey responses
- ⭕ Download PDF certificate
- ⭕ Email confirmation
- ⭕ Social share completion

---

## 🔐 SECURITY CONSIDERATIONS

1. **Authorization**
   - Only authenticated alumni can access
   - Alumni can only see/edit their own responses
   - Check session is active and within date range

2. **Validation**
   - Server-side validation for all inputs
   - Sanitize text inputs
   - Validate question/option IDs exist
   - Check question belongs to session

3. **Rate Limiting**
   - Limit API calls for auto-save
   - Prevent spam submissions

---

## 📈 METRICS TO TRACK

1. **Response Rate**
   - Total alumni invited
   - Total responses started
   - Total responses completed
   - Completion rate %

2. **Time Metrics**
   - Average time to complete
   - Time per question
   - Dropout points

3. **Data Quality**
   - Required fields completion
   - Optional fields completion
   - Text answer length

---

## 🚀 DEPLOYMENT CHECKLIST

- [ ] Create Answer model
- [ ] Create SurveyController
- [ ] Add routes
- [ ] Create view files
- [ ] Create question type partials
- [ ] Implement auto-save JS
- [ ] Implement validation
- [ ] Test all question types
- [ ] Test draft save/resume
- [ ] Test submission
- [ ] Mobile responsive check
- [ ] Accessibility audit
- [ ] Performance testing
- [ ] Documentation

---

**Estimated Total Time: 10-15 hours**
**Priority: High**
**Complexity: Medium-High**

