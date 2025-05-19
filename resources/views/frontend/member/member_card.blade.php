<div class="col-sm-6 col-md-4 col-lg-3">
    <a class="card shadow-lg mb-3" href="{{ route('frontend.viewProfile', $item->id) }}" target="_blank">
        <div class="card-body info-box-member">
            <div class="member-profile d-flex gap-2 align-items-center">
                <img class="member-profile-img"
                     src="{{ asset($item->profileImage) ?? asset('frontend_assets/img/profile.png') }}"
                     alt="Profile" loading="lazy" style="border-radius: 50%;">
                <h5 class="text-dark h5">
                    {{ $item->name }}
                </h5>
            </div>
            <div class="card-text pt-1 text-center">
                Alumni Id: {{ $item->alumni_id }}
                <br>
                Membership Status: <span class="text-success">{{ $item->cips_membership_status ?? 'N/A' }}</span> 
            </div>
        </div>
    </a>
</div>
