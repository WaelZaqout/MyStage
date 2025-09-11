   <!-- Notifications Settings -->
                    {{-- <div id="notifications" class="settings-tab">
                        <form action="{{ route('profile.settings.updateNotifications') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <h3 style="margin-bottom: 1rem; color: #333;">الإشعارات</h3>
                            <label>
                                <input type="checkbox" name="notify_courses"
                                    {{ Auth::user()->notify_courses ? 'checked' : '' }}> إشعارات الدورات
                            </label><br>
                            <label>
                                <input type="checkbox" name="notify_achievements"
                                    {{ Auth::user()->notify_achievements ? 'checked' : '' }}> إشعارات الإنجازات
                            </label><br>
                            <label>
                                <input type="checkbox" name="notify_offers"
                                    {{ Auth::user()->notify_offers ? 'checked' : '' }}> العروض الخاصة
                            </label><br>
                            <label>
                                <input type="checkbox" name="notify_messages"
                                    {{ Auth::user()->notify_messages ? 'checked' : '' }}> الرسائل من المدربين
                            </label><br>

                            <button type="submit" class="btn-primary">حفظ الإشعارات</button>
                        </form>
                    </div> --}}
